<?php

/*
* wrap iframe to responsive markup
*/

function embed_responsive($atts, $shortcode_content = null)
{
  return '<span class="embed-responsive">' . $shortcode_content . '</span>';
}

add_shortcode('embed-responsive', 'embed_responsive');