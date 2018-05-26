<?php

/*
* Thumbnail list shortcode
*/

/*
* Wrap
*/

function thumbnail_list($atts, $shortcode_content = null)
{
  $config = array
  (
    'col' => 2, // 3, 4
    'tplWrap' => '<div class="thumbnail thumbnail_col_%1$s">%2$s</div>',
  );

  $config = shortcode_atts($config, $atts, 'thumbnail-list');

  return sprintf($config['tplWrap'], $config['col'], do_shortcode($shortcode_content));
}
add_shortcode('thumbnail-list', 'thumbnail_list');

/*
* Row
*/

function thumbnail_row($atts, $shortcode_content = null)
{
  $config = array
  (
    'tplRow' => '<div class="thumbnail__row">%s</div>'
  );

  $config = shortcode_atts($config, $atts, 'thumbnail-row');

  return sprintf($config['tplRow'], do_shortcode($shortcode_content));
}
add_shortcode('thumbnail-row', 'thumbnail_row');

/*
* Item
*/

function thumbnail_item($atts, $shortcode_content = null)
{
  $config = array
  (
    'url' => '#',
    'img' => 'http://placehold.it/385x257',
    'title' => 'Example title',
    'tplItem' => '<div class="thumbnail__item"><a href="%1$s" class="thumb-item">%2$s</a></div>',
    'tplImage' => '<div class="thumb-item__img"><img src="%s"></div>',
    'tplTitle' => '<div class="thumb-item__title">%s</div>'
  );

  $config = shortcode_atts($config, $atts, 'thumbnail-row');

  $chunkImage = sprintf($config['tplImage'], $config['img']);
  $chunkTitle = sprintf($config['tplTitle'], $config['title']);
  $chunkItem = sprintf($config['tplItem'], $config['url'], $chunkImage . $chunkTitle);

  return $chunkItem;
}
add_shortcode('thumbnail-item', 'thumbnail_item');