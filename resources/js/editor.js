import * as monaco from 'monaco-editor';

window.initEditor = () => {
    const config = window.editorConfig || {};

    monaco.editor.create(document.getElementById('editor'), {
        value: config.value || '',
        language: config.language || 'javascript',
        theme: 'vs-light',
        readOnly: true,

        quickSuggestions: false,
        suggestOnTriggerCharacters: false,
        parameterHints: { enabled: false },
        wordBasedSuggestions: false,
    });
};