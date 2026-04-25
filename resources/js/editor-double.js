import * as monaco from "monaco-editor";

window.initEditor = () => {
    const config = window.editorConfig || {};

    monaco.editor.create(document.getElementById("editor_1"), {
        value: config.value_1 || "",
        language: config.language_1 || "javascript",
        theme: "vs-light",
        readOnly: true,

        quickSuggestions: false,
        suggestOnTriggerCharacters: false,
        parameterHints: { enabled: false },
        wordBasedSuggestions: false,
    });

    monaco.editor.create(document.getElementById("editor_2"), {
        value: config.value_2 || "",
        language: config.language_2 || "javascript",
        theme: "vs-light",
        readOnly: true,

        quickSuggestions: false,
        suggestOnTriggerCharacters: false,
        parameterHints: { enabled: false },
        wordBasedSuggestions: false,
    });
};
