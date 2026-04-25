<?php

namespace App\View\Components\Editor;

use Illuminate\Foundation\Inspiring;
use Illuminate\View\Component;

class EditorDouble extends Component
{
    public function __construct(
        public $code1 = null,
        public $language1 = 'plaintext',
        public $mediaType1 = null,
        public $mediaData1 = null,
        public $code2 = null,
        public $language2 = 'plaintext',
        public $mediaType2 = null,
        public $mediaData2 = null
    ) {
        $this->code1 = !empty($code1) ? $code1 : Inspiring::quote();
        $this->code2 = !empty($code2) ? $code2 : Inspiring::quote();
    }

    public function render()
    {
        return view('components.editor.editor-double');
    }
}
