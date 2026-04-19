<?php

namespace App\View\Components\Editor;

use Illuminate\Foundation\Inspiring;
use Illuminate\View\Component;

class Editor extends Component
{
    public $code;

    public $language;

    public $mediaType;

    public $mediaData;

    public function __construct($code = null, $language = 'plaintext', $mediaType = null, $mediaData = null)
    {
        $this->code = ! empty($code) ? $code : Inspiring::quote();
        $this->language = $language;
        $this->mediaType = $mediaType;
        $this->mediaData = $mediaData;
    }

    public function render()
    {
        return view('components.editor.editor');
    }
}
