(function (blocks, editor, element) {
  var el = element.createElement;

  blocks.registerBlockType('no-translation-gutenberg/paragraph', {
    title: 'No-Translation',
    icon: 'translation',
    category: 'text',
    attributes: {
      content: {
        type: 'string',
        source: 'html',
        selector: 'p',
      },
    },
    edit: function (props) {
      var content = props.attributes.content;
      function onChangeContent(newContent) {
        props.setAttributes({ content: newContent });
      }

      return el(
        'div',
        { className: 'no-translation' },
        el(editor.RichText, {
          tagName: 'p',
          value: content,
          placeholder: 'Add No Translation text here...',
          onChange: onChangeContent,
        })
      );
    },
    save: function (props) {
      return el(editor.RichText.Content, {
        tagName: 'p',
        className: 'no-translation',
        value: props.attributes.content,
      });
    },
  });
})(window.wp.blocks, window.wp.editor, window.wp.element);
