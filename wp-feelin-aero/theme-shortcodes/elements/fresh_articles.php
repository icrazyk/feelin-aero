<?php

function fresh_articles($atts, $shortcode_content = null)
{
  global $post;
  $items = '';

  $config = array
  (
    'numberposts' => 6,
    'tplWrap' => '<ul class="list-new">%s</ul>',
    'tplItem' => 
        '<li class="list-new__item">'
        . '<div class="newitem" onclick="location.href=\'%s\'">'
          . '<div class="newitem__img" style="background-image: url(%s)"></div>'
          . '<div class="newitem__title">%s</div>'
        . '</div>'
      . '</li>'
  );

  $config = shortcode_atts($config, $atts, 'listing-inner-this');
  $posts = get_posts(array('numberposts' => $config['numberposts']));

  foreach($posts as $post)
  { 
    setup_postdata($post);
    $items .= sprintf($config['tplItem'], get_the_permalink(), get_the_post_thumbnail_url($post, 'medium'), get_the_title());
  }

  wp_reset_postdata();
  return sprintf($config['tplWrap'], $items);
}

add_shortcode('fresh-articles', 'fresh_articles');
