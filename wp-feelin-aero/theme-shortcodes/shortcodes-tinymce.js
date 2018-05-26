(function()
{
  tinymce.PluginManager.add('shortcodes_mce_button', function( editor, url )
  { // shortcodes_mce_button - ID кнопки
    editor.addButton('shortcodes_mce_button', 
    {  // shortcodes_mce_button - ID кнопки, везде должен быть одинаковым
      text: 'Шорткоды', // текст кнопки, если вы хотите, чтобы ваша кнопка содержала только иконку, удалите эту строку
      title: 'Вставить шорткод', // всплывающая подсказка
      icon: false, // тут можно указать любую из существующих векторных иконок в TinyMCE либо собственный CSS-класс
      type: 'menubutton',
      menu: 
      [
        {
          text: '[listing-inner-this]',
          tooltip: 'Список внутренних страниц',
          onclick: function() 
          {
            editor.windowManager.open({
              title: 'Параметры списка документов',
              body: 
              [
                {
                  type: 'textbox',
                  name: 'id',
                  label: 'ID документа "родителя". По умол. текущий документ.'
                }
              ],
              onsubmit: function(e)
              {
                var id = e.data.id ? ' id="' + e.data.id + '"' : '';
                editor.insertContent('[listing-inner-this' + id + ']');
              }
            })
          }
        },
        {
          text: '[thumbnail-inner-this]',
          tooltip: 'Галерея внутренних страниц',
          onclick: function() 
          {
            editor.windowManager.open({
              title: 'Параметры галереи внутренних страниц',
              body: 
              [
                {
                  type: 'textbox',
                  name: 'id',
                  label: 'ID документа "родителя". По умол. текущий документ.'
                },
                {
                  type: 'listbox',
                  name: 'col',
                  label: 'Кол-во колонок',
                  'values':
                  [
                    {
                      text: 'Две', 
                      value: 2
                    },
                    {
                      text: 'Три', 
                      value: 3
                    },
                    {
                      text: 'Четыре', 
                      value: 4
                    }
                  ]
                }
              ],
              onsubmit: function(e)
              {
                var prop = [];
                prop[0] = e.data.id ? ' id="' + e.data.id + '"' : '';
                prop[1] = e.data.col && e.data.col !== 2 ? ' col="' + e.data.col + '"' : '';
                prop = prop.join('');
                prop = prop ? ' ' + prop : '';
                editor.insertContent('[thumbnail-inner-this' + prop + ']');
              }
            })
          }
        },
        {
          text: '[embed-responsive]',
          tooltip: 'Обертка для встроенных элементов',
          onclick: function() 
          {
            editor.windowManager.open({
              title: 'Обертка для встроенных элементов',
              body: 
              [
                {
                  type: 'textbox',
                  name: 'embed',
                  label: 'Код встраиваемого элемента'
                }
              ],
              onsubmit: function(e)
              {
                editor.insertContent('[embed-responsive]' + e.data.embed + '[/embed-responsive]');
              }
            })
          }
        },
        {
          text: '[fresh-articles]',
          tooltip: 'Свежие статьи',
          onclick: function() 
          {
            editor.insertContent('[fresh-articles]');
          }
        },
        {
          text: '[slider]',
          tooltip: 'Слайдер',
          onclick: function() 
          {
            editor.windowManager.open({
              title: 'Параметры слайдера',
              body: 
              [
                {
                  type: 'textbox',
                  name: 'mod',
                  label: 'Модификатор слайдера'
                }
              ],
              onsubmit: function(e)
              {
                var mod = e.data.mod ? ' mod="' + e.data.mod + '"' : '';
                editor.insertContent('[slider' + mod + ']');
              }
            })
          }
        }
      ],
    });
  });
})();