<?php

require_once get_template_directory() . '/theme-shortcodes/elements/thumbnail_inner_this.php';
require_once get_template_directory() . '/theme-shortcodes/elements/listing_inner_this.php';
require_once get_template_directory() . '/theme-shortcodes/elements/thumbnail_list.php';
require_once get_template_directory() . '/theme-shortcodes/elements/fly_places.php';
require_once get_template_directory() . '/theme-shortcodes/elements/embed_responsive.php';
require_once get_template_directory() . '/theme-shortcodes/elements/fresh_articles.php';
require_once get_template_directory() . '/theme-shortcodes/elements/slider.php';

// Хуки
function shortcodes_add_mce_button()
{
  // проверяем права пользователя - может ли он редактировать посты и страницы
  if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) )
  {
    return; // если не может, то и кнопка ему не понадобится, в этом случае выходим из функции
  }
  // проверяем, включен ли визуальный редактор у пользователя в настройках (если нет, то и кнопку подключать незачем)
  if ( 'true' == get_user_option( 'rich_editing' ) )
  {
    add_filter( 'mce_external_plugins', 'shortcodes_add_tinymce_script' );
    add_filter( 'mce_buttons', 'shortcodes_register_mce_button' );
  }
}

add_action('admin_head', 'shortcodes_add_mce_button');
 
// В этой функции указываем ссылку на JavaScript-файл кнопки
function shortcodes_add_tinymce_script( $plugin_array )
{
  $plugin_array['shortcodes_mce_button'] = get_template_directory_uri() . '/theme-shortcodes/shortcodes-tinymce.js'; // shortcodes_mce_button - идентификатор кнопки
  return $plugin_array;
}
 
// Регистрируем кнопку в редакторе
function shortcodes_register_mce_button( $buttons )
{
  array_push( $buttons, 'shortcodes_mce_button' ); // shortcodes_mce_button - идентификатор кнопки
  return $buttons;
}