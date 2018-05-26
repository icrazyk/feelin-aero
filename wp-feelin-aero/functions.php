<?php

if ( ! function_exists( 'feelinaero_setup' ) ) :

function feelinaero_setup() {

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );


	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in one locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'feelinaero' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 */
	add_theme_support( 'post-formats', array(
		'gallery'
	) );
}
endif; // feelinaero_setup
add_action( 'after_setup_theme', 'feelinaero_setup' );

/**
 * Registers a widget area.
 */
function feelinaero_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'feelinaero' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'feelinaero' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'feelinaero_widgets_init' );

/**
 * https://github.com/sindresorhus/gulp-rev/blob/master/integration.md
 * @param  string  $filename
 * @return string
 */
function asset_path($filename) {
    $manifest_path = get_template_directory() . '/build/rev-manifest.json';

    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), TRUE);
    } else {
        $manifest = [];
    }
    
    if (array_key_exists($filename, $manifest)) {
        return $manifest[$filename];
    }

    return $filename;
}

/**
 * Enqueues scripts and styles.
 */
function feelinaero_scripts() {

	// Theme stylesheet.
	wp_enqueue_style( 'feelinaero-style', get_template_directory_uri() . '/build/' . asset_path('style.css') );

	// Theme font
	wp_enqueue_style( 'feelinaero-font', 'https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=cyrillic', array('feelinaero-style') );

	// Theme scripts.
	wp_enqueue_script( 'feelinaero-script', get_template_directory_uri() . '/build/' . asset_path('script0.js'), array(), false, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'feelinaero_scripts' );

/**
 * Adds custom classes to the array of body classes.
 */
function feelinaero_body_classes( $classes ) {

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'feelinaero_body_classes' );


/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 */
function feelinaero_widget_tag_cloud_args( $args ) 
{
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'feelinaero_widget_tag_cloud_args' );

add_filter('kama_breadcrumbs_default_args', function($args)
{
	$args['markup']  = array(
      'wrappatt'  => '<ul class="breadcrumb">%s</ul>',
      'linkpatt'  => '<li><a href="%s">%s</a></li>',
      'sep_after' => ''
    );
	$args['title_patt'] = '<li class="active"><h1>%s</h1></li>';
	$args['on_front_page'] = false;
	return $args;
});

/*
* Delete recent comments default styles
*/
function remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'remove_recent_comments_style');

/*
* Add wrapper for embed
*/
function add_wrap_for_embed($return, $url, $attr)
{
	return '<span class="embed-responsive">' . $return . '</span>';
}
add_action('embed_oembed_html', 'add_wrap_for_embed', 10, 3);

/*
* Remove <p> and <br> between shortcodes
*/
// remove_filter( 'the_content', 'wpautop' );
// add_filter( 'the_content', 'wpautop' , 12);

/*
* Shortcodes
*/
require_once get_template_directory() . '/theme-shortcodes/shortcodes.php';

/*
* Make gallery preview
*/

function filter_gallery_preview($content)
{
  global $post;

  $tpl = array(
    'wrap' => '<a href="%1$s" class="gallery-preview"><span class="gallery-preview__image">%2$s</span><span class="gallery-preview__title">%3$s фото</span></a>',
    'item' => '<img src="%s">'
  );

  preg_match('/\[gallery.+ids=\"(.+)\"(.?)+\]/', $content, $result);

  // if has gallery

  if(!empty($result[1]))
  {
    $gallery_ids = explode(',', $result[1]);
    $gallery_length = count($gallery_ids);

    if($gallery_length > 6)
    {
      $gallery_trim = array_slice($gallery_ids, 0, 1);
      $chunkImages = '';

      foreach ($gallery_trim as $i => $id)
      {
        $url = wp_get_attachment_image_url($id, 'large');
        $chunkImages .= sprintf($tpl['item'], $url);
      }

      $permalink = get_permalink($post->ID);
      $chunkWrap = '';
      $chunkWrap .= sprintf($tpl['wrap'], $permalink, $chunkImages, $gallery_length);
      $content = preg_replace('/\[gallery.+\]/', $chunkWrap, $content, 1);
    }
  }

  return $content;
}

function filter_gallery_preview_init()
{
  if(!is_single()) 
  {
    add_filter('the_content', 'filter_gallery_preview', 1, 1);
  }
}

add_action( 'wp_head', 'filter_gallery_preview_init' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/*
* Toolbar to bottom
*/

add_action('admin_bar_init', function(){
	remove_action('wp_head', '_admin_bar_bump_cb');
});

/*
* Remove WP version
*/

remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

/*
* Remove publish from email
*/

add_filter('xmlrpc_enabled', '__return_false');

/*
* Disable wpcf7 styles
*/

add_filter( 'wpcf7_load_css', '__return_false' );

/*
* Send order to VK
*/

function sendOrderToVk ($cf7)
{ 
  if($_POST['_wpcf7'] !== '979') return;
  $user_ids = array('14124526', '3277193');
  $date = new DateTime('now');
  $date->add(new DateInterval('PT5H'));
  $date = $date->format('Y-m-d H:i');
  $message = "ЗАЯВКА \"ПОЛЕТАТЬ\" \n Услуга: {$_POST['service']} \n От: {$_POST['your-name']} \n Телефон: {$_POST['your-tel']} \n Сообщение: {$_POST['your-message']} \n Дата: $date";
 
  foreach($user_ids as $id)
  {	  
    $request_params = array(
      'user_id' => $id,
      'message' => $message,
      'v' => '5.52',
      'access_token' => 'e5ff358520edb8a5d9703b1f719d1d16fd089e021a75bf0c8dacd075edca6fc2e7392ed6f973f96f9d998'
    );

    $get_params = http_build_query($request_params);
    file_get_contents('https://api.vk.com/method/messages.send?'. $get_params);
  }
}

add_action("wpcf7_before_send_mail", "sendOrderToVk", 10, 1);
