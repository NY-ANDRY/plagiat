<?php

namespace App\Http\Controllers\Plagiarism;

use App\Http\Controllers\Controller;
use App\Jobs\PlagiarismCheckProcess;
use App\Models\AlgoProp;
use App\Models\Plagiarism;
use App\Models\PlagiarismResult;
use App\Models\PlagiarismStatut;
use App\Models\Submission;
use App\Services\ZipService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Arr;

class PlagiarismController extends Controller
{

    public function checkPlagiarism(Request $request): RedirectResponse
    {
        $algoId = $request->input('algo-id');
        $examId = $request->input('exam-id');

        $plagiarism = Plagiarism::create([
            'algo_id' => $algoId,
            'exam_id' => $examId
        ]);
        $processingStatus = PlagiarismStatut::where('name', 'pending')->firstOrCreate(['name' => 'pending']);
        $plagiarism->statuses()->syncWithoutDetaching([$processingStatus->id]);

        $props = AlgoProp::where('algo_id', '=', $algoId)->get();

        foreach ($props as $prop) {
            $value = $request->input("props-{$prop->id}");
            $plagiarism->algoProps()->create([
                'algo_prop_id' => $prop->id,
                'plagiarism_id' => $plagiarism->id,
                'value' => $value,
            ]);
        }

        PlagiarismCheckProcess::dispatch($plagiarism->id);

        return back();
    }


    public function compare(PlagiarismResult $pr, Request $request): View
    {
        $submission1 = $pr->submission1;
        $submission2 = $pr->submission2;

        $this->canReadSubmission($submission1, $request);
        $this->canReadSubmission($submission2, $request);

        if (!$request->has('file')) {
            $previous = url()->previous();
            if (!str_contains($previous, $request->path())) {
                session(['previous_url' => $previous]);
            }
        }

        $user = $request->user();

        $code1 = null;
        $language1 = 'plaintext';
        $mediaType1 = null;
        $mediaData1 = null;

        $code2 = null;
        $language2 = 'plaintext';
        $mediaType2 = null;
        $mediaData2 = null;

        $zipPath1 = Storage::disk('public')->path($submission1->url_file);
        $structure1 = ZipService::getStructure($zipPath1);
        $flatFiles1 = Arr::flatten($structure1);

        $zipPath2 = Storage::disk('public')->path($submission2->url_file);
        $structure2 = ZipService::getStructure($zipPath2);
        $flatFiles2 = Arr::flatten($structure2);

        if ($request->has('file')) {
            $requestedFile1 = $request->query('file');

            if (in_array($requestedFile1, $flatFiles1)) {
                $fileInfo1 = ZipService::getFileContentAndLanguage($zipPath1, $requestedFile1);
                $code1 = $fileInfo1['code'];
                $language1 = $fileInfo1['language'];
                $mediaType1 = $fileInfo1['mediaType'];
                $mediaData1 = $fileInfo1['mediaData'];
            }
        }

        if ($request->has('file2')) {
            $requestedFile2 = $request->query('file2');

            if (in_array($requestedFile2, $flatFiles2)) {
                $fileInfo2 = ZipService::getFileContentAndLanguage($zipPath2, $requestedFile2);
                $code2 = $fileInfo2['code'];
                $language2 = $fileInfo2['language'];
                $mediaType2 = $fileInfo2['mediaType'];
                $mediaData2 = $fileInfo2['mediaData'];
            }
        }

        $fallbackUrl = route('dashboard');
        if ($user->hasRole('prof')) {
            $fallbackUrl = route('prof.exams.show', $submission1->exam_id);
        } elseif ($user->hasRole('student')) {
            $fallbackUrl = route('student.exam', $submission1->exam_id);
        }

        $backUrl = session('previous_url', $fallbackUrl);

        return View('submission.plagiarism', compact(
            'submission1',
            'submission2',
            'code1',
            'language1',
            'mediaType1',
            'mediaData1',
            'code2',
            'language2',
            'mediaType2',
            'mediaData2',
            'structure1',
            'structure2',
            'backUrl',
            'pr'
        ));
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

        if (!$authorized) {
            abort(403, 'Unauthorized access to submission.');
        }
    }

    public function delete(Plagiarism $plagiarism): RedirectResponse
    {
        $plagiarism->delete();
        return back();
    }
}
