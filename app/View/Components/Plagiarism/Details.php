<?php

namespace App\View\Components\Plagiarism;

use App\Models\Plagiarism;
use App\Models\PlagiarismResult;
use Illuminate\View\Component;

class Details extends Component
{
    public string $idPlagiarism;
    public Plagiarism $plagiarism;
    public $results;

    public function __construct(string $idPlagiarism)
    {
        $this->idPlagiarism = $idPlagiarism;
        $this->init();
    }

    public function init()
    {
        $this->plagiarism = Plagiarism::with(['results'])->find($this->idPlagiarism);
        $this->results = PlagiarismResult::where('plagiarism_id', '=', $this->idPlagiarism)->orderByDesc('rate')->get();
    }

    public function render()
    {
        return view('components.plagiarism.details');
    }
}
