<?php
/*
* Thumbnail inner pages shortcode
*/
function thumbnail_inner_this($atts)
{
  global $post;

  $config = array
  (
    'id' => get_the_ID(),
    'col' => 2, // 3, 4
    'tplWrap' => '<div class="thumbnail thumbnail_col_%1$s">%2$s</div>',
    'tplRow' => '<div class="thumbnail__row">%s</div>',
    'tplItem' => '<div class="thumbnail__item"><a href="%1$s" class="thumb-item">%2$s</a></div>',
    'tplImage' => '<div class="thumb-item__img"><img src="%s"></div>',
    'tplTitle' => '<div class="thumb-item__title">%s</div>'
  );

  $config = shortcode_atts($config, $atts, 'thumbnail-inner-this');

  $thumbnails = '';
  $row = '';
  $rows = '';

  $args = array
  (
    'sort_column'  => 'menu_order',
    'parent'       => $config['id']
  );

  $pages = get_pages($args);

  foreach ($pages as $key => $post) 
  {
    setup_postdata($post);
    $k = $key == 0 ? 1 : $key;
    $chunkImage = sprintf($config['tplImage'], get_the_post_thumbnail_url());
    $chunkTitle = sprintf($config['tplTitle'], get_the_title());
    $chunkItem = sprintf($config['tplItem'], get_the_permalink(), $chunkImage . $chunkTitle);
    if($k % $config['col'])
    {
      $row .= $chunkItem;
    }
    else
    {
      $rows .= sprintf($config['tplRow'], $row);
      $row = $chunkItem;
    }
  }
  wp_reset_postdata();

  $rows .= sprintf($config['tplRow'], $row);

  $thumbnails .= sprintf($config['tplWrap'], $config['col'], $rows);

  return $thumbnails;
}
add_shortcode('thumbnail-inner-this', 'thumbnail_inner_this');