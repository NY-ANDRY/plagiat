<?php

namespace App\View\Components\Plagiarism;

use App\Models\Exam;
use App\Models\Plagiarism;
use Illuminate\View\Component;

class Details extends Component
{
    public Plagiarism $plagiarism;

    public function __construct(Plagiarism $plagiarism)
    {
        $this->plagiarism = $plagiarism;
        $this->init();
    }

    public function init()
    {
    }

    public function render()
    {
        return view('components.plagiarism.details');
    }
}
