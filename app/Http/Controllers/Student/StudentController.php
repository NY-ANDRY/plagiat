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
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $exams = Exam::orderByOpenStatus();
        $submissions = Submission::history($user->id);

        return view('student.dashboard', compact('exams', 'submissions'));
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

        $submission = Submission::where('exam_id', $id)
            ->where('student_id', $user->id)
            ->first();
        if (!empty($submission)) {
            $submission->delete();
        }

        $file = $request->file('file');
        $url_file = $file->store('exam_submissions', 'public');
        Submission::create([
            'exam_id' => $id,
            'student_id' => $user->id,
            'url_file' => $url_file,
            'file_extension' => $file->extension(),
            'file_filename' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
        ]);

        return redirect()->route('student.exam', $id);
    }

    public function profile(Request $request): View
    {
        $user = $request->user();
        return view('student.profile', compact('user'));
    }
}
