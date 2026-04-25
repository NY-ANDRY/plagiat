<?php

namespace App\View\Components\Plagiarism;

use App\Models\Plagiarism;
use Illuminate\View\Component;

class States extends Component
{
    public string $idPlagiarism;
    public Plagiarism $plagiarism;

    public function __construct(string $idPlagiarism)
    {
        $this->idPlagiarism = $idPlagiarism;
        $this->plagiarism = Plagiarism::find($idPlagiarism);
        $this->init();
    }

    public function init()
    {
    }

    public function render()
    {
        return view('components.plagiarism.states');
    }
}
