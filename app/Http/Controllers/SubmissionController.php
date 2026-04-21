<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Services\ZipService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function read(Submission $submission, Request $request): View
    {
        $this->canReadSubmission($submission, $request);

        if (! $request->has('file')) {
            $previous = url()->previous();
            if (! str_contains($previous, $request->path())) {
                session(['previous_url' => $previous]);
            }
        }

        $user = $request->user();

        $code = null;
        $language = 'plaintext';
        $structure = [];
        $mediaType = null;
        $mediaData = null;
        $flatFiles = [];

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

        $fallbackUrl = route('dashboard');
        if ($user->hasRole('prof')) {
            $fallbackUrl = route('prof.exams.show', $submission->exam_id);
        } elseif ($user->hasRole('student')) {
            $fallbackUrl = route('student.exam', $submission->exam_id);
        }

        $backUrl = session('previous_url', $fallbackUrl);

        return view('submission.read', compact('submission', 'code', 'language', 'structure', 'mediaType', 'mediaData', 'backUrl'));
    }

    public function download(Submission $submission, Request $request)
    {
        $this->canReadSubmission($submission, $request);

        $zipPath = Storage::disk('public')->path($submission->url_file);

        return response()->download(
            $zipPath,
            $submission->file_filename.'.'.$submission->file_extension
        );
    }

    private function canReadSubmission(Submission $submission, Request $request)
    {
        $user = $request->user();

        $authorized = false;

        if ($user->hasRole('student') && $submission->student_id == $user->id) {
            $authorized = true;
        }
        if ($user->hasRole('prof')) {
            $authorized = true;
        }

        if (! $authorized) {
            abort(403, 'Unauthorized access to submission.');
        }
    }
}
