<?php

namespace App\View\Components\Exam;

use App\Models\Exam;
use Illuminate\View\Component;

class ExamCard extends Component
{
    public Exam $exam;

    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    public function render()
    {
        return view('components.exam.exam-card');
    }
}
