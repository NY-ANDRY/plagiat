<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Submission;
use App\Services\ZipService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
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

    public function exam($id, Request $request): View
    {
        $exam = Exam::details($id);
        $user = $request->user();
        $submission = Submission::where('exam_id', $id)->where('student_id', $user->id)->first();

        return view('student.exam.view', compact('exam', 'submission'));
    }

    public function view($id, Request $request): View
    {
        $user = $request->user();
        $submission = Submission::where('exam_id', $id)->where('student_id', $user->id)->first();

        $code = null;
        $language = 'plaintext';
        $structure = [];
        $mediaType = null;
        $mediaData = null;

        $flatFiles = [];
        if ($submission) {
            $zipPath = Storage::disk('public')->path($submission->url_file);
            $structure = ZipService::getStructure($zipPath);

            $flatFiles = Arr::flatten($structure);

            if ($request->has('file') && in_array($request->query('file'), $flatFiles)) {
                $requestedFile = $request->query('file');

                $fileInfo = ZipService::getFileContentAndLanguage($zipPath, $requestedFile);
                $code = $fileInfo['code'];
                $language = $fileInfo['language'];
                $mediaType = $fileInfo['mediaType'];
                $mediaData = $fileInfo['mediaData'];
            }
        }

        return view('student.exam.details', compact('submission', 'code', 'language', 'structure', 'mediaType', 'mediaData'));
    }

    public function download($id, Request $request)
    {
        $user = $request->user();

        $submission = Submission::where('exam_id', $id)
            ->where('student_id', $user->id)
            ->firstOrFail();

        $zipPath = Storage::disk('public')->path($submission->url_file);

        return response()->download(
            $zipPath,
            $submission->file_filename . '.' . $submission->file_extension
        );
    }

    public function submission($id, Request $request): RedirectResponse
    {
        if (!$request->hasFile('file')) {
            return back()->with('error', 'No file selected');
        }
        $user = $request->user();

        $submission = Submission::where('exam_id', $id)->where('student_id', $user->id)->first();
        if (!empty($submission)) {
            Storage::disk('public')->delete($submission->url_file);
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

    public function removeSubmission($id, Request $request): RedirectResponse
    {
        $user = $request->user();

        $submission = Submission::where('exam_id', $id)->where('student_id', $user->id)->first();
        if (!empty($submission)) {
            $submission->delete();
        }

        return redirect()->route('student.exam', $id);
    }

    public function profile(Request $request): View
    {
        $user = $request->user();

        return view('student.profile', compact('user'));
    }
}
