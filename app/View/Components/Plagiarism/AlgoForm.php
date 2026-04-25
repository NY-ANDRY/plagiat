<?php

namespace App\View\Components\Plagiarism;

use App\Models\Algo as AlgoModel;
use App\Models\Exam;
use Illuminate\View\Component;

class AlgoForm extends Component
{
    public $idExam;
    public $idAlgo;
    public $curAlgo;
    public $algos;

    public function __construct($idExam, $idAlgo = null)
    {
        $this->idExam = $idExam;
        $this->idAlgo = $idAlgo;
        $this->init();
    }

    public function init()
    {
        $this->algos = AlgoModel::all();
        if ($this->idAlgo != null) {
            $this->curAlgo = AlgoModel::with(['props'])->find($this->idAlgo);
        }
    }

    public function render()
    {
        return view('components.plagiarism.algo-form');
    }
}
