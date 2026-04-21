<?php

namespace App\View\Components\Plagiarism;

use Illuminate\View\Component;

class View extends Component
{
    public $idExam;
    // public $exam;

    public function __construct($idExam = null)
    {
        $this->idExam = $idExam;
    }

    public function render()
    {
        return view('components.plagiarism.view');
    }
}
