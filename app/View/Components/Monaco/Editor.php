<?php

namespace App\View\Components\Monaco;

use Illuminate\Foundation\Inspiring;
use Illuminate\View\Component;

class Editor extends Component
{
    public $code;

    public $language;

    public function __construct($code = null, $language = 'txt')
    {
        $this->code = ! empty($code) ? $code : Inspiring::quote();
        $this->language = $language;
    }

    public function render()
    {
        return view('components.monaco.editor');
    }
}
