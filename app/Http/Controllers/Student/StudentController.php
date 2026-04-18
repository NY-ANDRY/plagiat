<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function dashboard(): View
    {
        return view('student.dashboard');
    }

    public function exams(): View
    {
        $exams = Exam::orderByOpenStatus();
        return view('student.exams', compact('exams'));
    }

    public function exam($id): View
    {
        $exam = Exam::details($id);
        return view('student.exam', compact('exam'));
    }

    public function submission($id, Request $request): RedirectResponse
    {
        if (!$request->hasFile('file')) {
            return back()->with('error', 'No file selected');
        }
        $user = $request->user();

        $submission = Submission::where('exam_id', '=', $id, 'and', 'student_id', '=', $user->id)->first();
        if (!empty($submission)) {
            $submission->delete();
        }

        $url_file = $request->file('file')->store('exam_submissions', 'public');
        Submission::create([
            'exam_id' => $id,
            'student_id' => $user->id,
            'url_file' => $url_file
        ]);

        return redirect()->route('student.exam', $id);
    }
}
