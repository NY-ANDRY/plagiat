<?php

namespace App\View\Components\Exam;

use App\Models\FileExtension;
use App\Models\FileRestriction;
use App\Models\FileType;
use App\Models\Setting;
use Illuminate\View\Component;

class ExamForm extends Component
{
    public $extensions;

    public $restrictions;

    public $fileTypes;

    public $separator;

    public $href;

    public function __construct()
    {
        $this->extensions = FileExtension::all();
        $this->restrictions = FileRestriction::all();
        $this->fileTypes = FileType::with(['restrictions'])->get();
        $separator = Setting::where('name', '=', 'input_separator')->first();
        if ($separator == null) {
            $separator = ['value' => '--'];
        }
        $this->separator = $separator;
    }

    public function render()
    {
        return view('components.exam.exam-form');
    }
}
