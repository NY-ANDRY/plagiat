<?php

namespace App\Http\Controllers\Prof;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Submission;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfController extends Controller
{
    public function dashboard(): View
    {
        $quote = Inspiring::quote();

        return view('prof.dashboard', compact('quote'));
    }

    public function exams(Request $request): View
    {
        $user = $request->user();
        $exams = Exam::where('creator_id', '=', $user->id)->get();
        $quote = Inspiring::quote();

        return view('prof.exam.views', compact('quote', 'exams'));
    }

    public function exam($id, Request $request): View
    {
        $submissions = Submission::where('exam_id', '=', $id)->get();
        $quote = Inspiring::quote();

        return view('prof.exam.details', compact('quote', 'submissions'));
    }

    public function student(): View
    {
        $quote = Inspiring::quote();

        return view('prof.student', compact('quote'));
    }
}
