<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prof\ExamCreateRequest;
use App\Models\Exam;
use App\Models\ExamStatus;
use App\Models\FileRestriction;
use App\Models\FileType;
use App\Models\Setting;
use App\Models\Submission;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfController extends Controller
{
    public function dashboard(): View
    {
        $quote = Inspiring::quote();

        return view('prof.dashboard', compact('quote'));
    }

    public function storeExam(ExamCreateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $exam = $user->exams()->create([
            'title' => $request->input('name'),
            'about' => $request->input('about'),
            'close_date' => $request->input('close_date'),
        ]);

        if ($request->has('extensions')) {
            $exam->fileExtensions()->sync($request->input('extensions'));
        }

        $restriction = $this->getRestriction($request);
        if (!empty($restriction)) {
            $exam->fileRestrictions()->sync($restriction);
        }

        $draftStatus = ExamStatus::where('label', 'Draft')->first();

        if ($draftStatus) {
            $exam->statuses()->attach($draftStatus->id, [
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('prof.exams.list')->with('success', 'Exam created successfully.');
    }

    private function getRestriction(Request $request): array
    {
        $result = [];
        $separator = Setting::where('name', '=', 'input_separator')->first();
        if ($separator == null) {
            $separator = '--';
        } else {
            $separator = $separator->value;
        }
        $fileTypes = FileType::all();

        foreach ($fileTypes as $fileType) {
            $restrictions = $request->input("restrictions-{$fileType->id}");
            if (empty($restrictions)) {
                continue;
            }
            $restricts = explode($separator, $restrictions);
            foreach ($restricts as $filename) {
                $cur = FileRestriction::where('name', '=', $filename)
                    ->where('file_type_id', '=', $fileType->id)->first();
                if ($cur == null) {
                    $cur = FileRestriction::create([
                        'name' => $filename,
                        'file_type_id' => $fileType->id,
                    ]);
                }
                $result[] = $cur->id;

            }
        }

        return $result;
    }

    public function exams(Request $request): View
    {
        $user = $request->user();
        $exams = Exam::where('creator_id', '=', $user->id)->orderByDesc('created_at')->get();
        $quote = Inspiring::quote();

        return view('prof.exam.views', compact('quote', 'exams'));
    }

    public function exam($id, Request $request): View
    {
        $submissions = Submission::where('exam_id', '=', $id)->orderBy('created_at')->get();
        $exam = Exam::find($id);
        $quote = Inspiring::quote();
        $idAlgo = $request->query('algo');

        return view('prof.exam.details', compact('quote', 'submissions', 'exam', 'idAlgo'));
    }

    public function student(): View
    {
        $quote = Inspiring::quote();

        return view('prof.student', compact('quote'));
    }
}
