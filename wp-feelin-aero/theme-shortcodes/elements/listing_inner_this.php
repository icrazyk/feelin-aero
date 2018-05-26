<?php
/*
* Listing inner pages shortcode
*/
function listing_inner_this($atts)
{
  global $post;

  $config = array
  (
    'id' => get_the_ID(),
    'tplWrap' => '<ul class="listing">%s</ul>',
    'tplItem' => '<li class="listing__item">%s</li>',
    'tplItemContent' => '<a href="%1$s">%2$s</a>'
  );

  $config = shortcode_atts($config, $atts, 'listing-inner-this');

  $args = array
  (
    'sort_column'  => 'menuindex',
    'parent'       => $config['id']
  );

  $pages = get_pages($args);

  $content = '';
  $listing = '';
  
  foreach ($pages as $key => $post) 
  {
    setup_postdata($post);
    $chunkContent = sprintf($config['tplItemContent'], get_the_permalink(), get_the_title());
    $chunkItem = sprintf($config['tplItem'], $chunkContent);
    $content .= $chunkItem;
  }
  wp_reset_postdata();

  $listing .= sprintf($config['tplWrap'], $content);

  return $listing;
}
add_shortcode('listing-inner-this', 'listing_inner_this');