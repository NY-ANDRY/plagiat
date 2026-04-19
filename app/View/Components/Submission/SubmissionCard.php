<?php

namespace App\View\Components\Submission;

use App\Models\Submission;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmissionCard extends Component
{
    public Submission $submission;

    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    public function render(): View|Closure|string
    {
        return view('components.submission.submission-card');
    }
}
