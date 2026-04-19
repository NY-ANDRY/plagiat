<?php

namespace App\View\Components\Exam;

use App\Models\Exam;
use Illuminate\View\Component;

class ExamCard extends Component
{
    public Exam $exam;

    public $href;

    public function __construct(Exam $exam, $href = '#')
    {
        $this->exam = $exam;
        $this->href = $href;
    }

    public function render()
    {
        return view('components.exam.exam-card');
    }
}
