<?php

namespace App\View\Components\Submission;

use App\Models\Submission;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmissionCard extends Component
{
    public Submission $submission;

    public $stop = false;

    public ?string $viewUrl;

    public function __construct($submission, $stop = false, $viewUrl = null)
    {
        $this->submission = $submission;
        $this->stop = $stop;
        $this->viewUrl = $viewUrl;

    }

    public function render(): View|Closure|string
    {
        return view('components.submission.submission-card');
    }
}
