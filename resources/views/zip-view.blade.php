@vite('resources/js/editor.js')

<div id="editor" style="height: 400px;"></div>

<script>
    window.editorConfig = {
        value: @json($code),
        language: @json($language)
    };
    document.addEventListener('DOMContentLoaded', () => {
        window.initEditor();
    });
</script>