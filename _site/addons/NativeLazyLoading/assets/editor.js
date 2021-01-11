/**
 * Automatically add img[loading="lazy"] attribute (tinymce)
 */
App.$(document).on('init-wysiwyg-editor', function(e, editor) {
  // editor.settings.schema = "html5";
  editor.settings.extended_valid_elements = "img[*]";
  editor.on('BeforeSetcontent', function(e){
    if (e.content.substr(0,5) === "<img " && e.content.indexOf(' loading=') == -1) {
      e.content = e.content.substr(0,5) + `loading="lazy" ` + e.content.substr(5);
      return e.content;
    }
  });
});

/**
 * Automatically add img[loading="lazy"] attribute (html-editor)
 */
App.$(document).on('init-html-editor', function(e, editor) {
  editor.editor.on("beforeChange", function(_, e) {
    if (e.text[0] && e.text[0].substr(0,5) === "<img " && e.text[0].indexOf(' loading=') == -1) {
      e.text[0] = e.text[0].substr(0,5) + `loading="lazy" ` + e.text[0].substr(5);
    }
  });
});
