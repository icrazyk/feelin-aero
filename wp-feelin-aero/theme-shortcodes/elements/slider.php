<?php

function slider($atts, $shortcode_content = null)
{
  global $post;
  $slides = '';

  $config = array
  (
    'mod' => '',
    'tplWrap' => '<div class="slider %s"><ul class="bxslider slider__this">%s</ul></div>',
    'tplItem' => 
        '<li>'
        . '<div class="slide" style="background-image:url(%s)">'
          . '<div class="slide__content">'
            . '<div class="slide-content">'
              . '<div class="slide-content__title"><span>%s</span></div>'
              . '<div class="slide-content__link"><a href="%s" class="slide__link">Подробнее</a></div>'
            . '</div>'
          . '</div>'
        . '</div>'
      . '</li>'
  );

  $config = shortcode_atts($config, $atts, 'slider');

  if(have_rows('slider_slide', $post->ID))
  {
    while(have_rows('slider_slide', $post->ID))
    {
      the_row();
      $slides .= sprintf($config['tplItem'], get_sub_field('slider_image'), get_sub_field('slider_title'), get_sub_field('slider_link'));
    }
  }

  return sprintf($config['tplWrap'], $config['mod'], $slides);
}

add_shortcode('slider', 'slider');