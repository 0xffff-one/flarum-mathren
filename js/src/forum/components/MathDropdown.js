import app from 'flarum/app';
import Component from 'flarum/Component';
import Dropdown from 'flarum/components/Dropdown';
import Button from 'flarum/components/Button';
import ItemList from 'flarum/utils/ItemList';
import icon from 'flarum/helpers/icon';
import apply from '../util/apply';

export default class extends Component {
  init() {
    this.textEditor = this.props.textEditor;

    // translation prefix
    this.localePrefix = 'the-turk-mathren.forum.textEditor.';

    // main BBCode delimiters
    this.mainBlockDelimiter = app.forum.attribute('mathRenMainBlockDelimiter');
    this.mainInlineDelimiter = app.forum.attribute('mathRenMainInlineDelimiter');
  }

  view() {
    return Dropdown.component({
      className: 'MathRenDropdown',
      buttonClassName: 'Button Button--flat',
      label: icon('fas fa-square-root-alt'),
      children: this.items().toArray()
    });
  }

  /**
   * Build an item list for the contents of the dropdown menu.
   *
   * @return {ItemList}
   */
  items() {
    const items = new ItemList();

    items.add('mathBlock', Button.component({
        icon: 'fas fa-vector-square',
        children: app.translator.trans(this.localePrefix + 'blockExpression'),
        onclick: () => {
          // opening tag (left delimiter)
          const leftDelim = this.mainBlockDelimiter['left'];
          // closing tag (right delimiter)
          const rightDelim = this.mainBlockDelimiter['right'];

          apply(this.textEditor, {
            prefix: leftDelim,
            suffix: rightDelim,
            multiline: true,
          });
        },
      }),
      50
    );

    items.add('mathInline', Button.component({
        icon: 'fas fa-grip-lines',
        children: app.translator.trans(this.localePrefix + 'inlineExpression'),
        onclick: () => {
          // opening tag (left delimiter)
          const leftDelim = this.mainInlineDelimiter['left'];
          // closing tag (right delimiter)
          const rightDelim = this.mainInlineDelimiter['right'];

          apply(this.textEditor, {
            prefix: leftDelim,
            suffix: rightDelim,
            multiline: true,
          });
        },
      }),
      0
    );

    return items;
  }
}
