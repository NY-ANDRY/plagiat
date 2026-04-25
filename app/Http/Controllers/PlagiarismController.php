<?php

namespace App\Http\Controllers;

use App\Models\Algo;
use App\Models\AlgoProp;
use App\Models\Plagiarism;
use App\Services\PlagiarismChecker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        $props = AlgoProp::where('algo_id', '=', $algoId)->get();

        foreach ($props as $prop) {
            $value = $request->input("props-{$prop->id}");
            $plagiarism->algoProps()->create([
                'algo_prop_id' => $prop->id,
                'plagiarism_id' => $plagiarism->id,
                'value' => $value,
            ]);
        }

        $checker = new PlagiarismChecker();
        $checker->compare($plagiarism);

        return back();
    }

}
