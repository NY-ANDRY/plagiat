<?php

namespace App\View\Components\Plagiarism;

use Illuminate\View\Component;

class View extends Component
{
    public $idExam;
    public $test;

    public function __construct($idExam = null)
    {
        $this->idExam = $idExam;
        $a = "hoho";
        $this->test = "test{$a}";
    }

    public function render()
    {
        return view('components.plagiarism.view');
    }
}
