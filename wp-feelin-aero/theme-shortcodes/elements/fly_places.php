<?php
/*
* Fly places block
*/

function get_place($id) {
  $filename = join(DIRECTORY_SEPARATOR, [TEMPLATEPATH, 'windguru/cache', $id . '.txt']);

  $contents = '';

  if(file_exists($filename))
  {
    $handle = fopen($filename, 'r');
    $contents = fread($handle, filesize($filename));
    fclose($handle);
  }

  return $contents;
}

function fly_places($atts)
{
  global $post;

  $config = array
  (
    'id' => $post->ID,
    'activeTabClass' => 'places-tabs__item_active',
    'activeContentClass' => 'places-contents__item_active',
    'tplWrap' =>  '<div class="places" id="fly-places">'
                  .'<div class="places__tabs"><ul class="places-tabs">%1$s</ul></div>'
                  .'<div class="places__contents"><ul class="places-contents">%2$s</ul></div>'
                  .'</div>%3$s',
    'tplItemTab' => "<li class='places-tabs__item %s' data-place='%s' data-widgets='%s'><span>%s</span></li>",
    'tplItemContent' => '<li id="%s" class="places-contents__item %s">'
                          .'<h2>%s</h2>'
                          .'<div class="places-contents-widget">'
                            .'<div class="places-contents-widget__row places-contents-widget__row_one"></div>'
                            .'<div class="places-contents-widget__row places-contents-widget__row_two"></div>'
                          .'</div>'
                          .'<h3>Описание</h3>%s'
                        .'</li>',
    'widgets' => array(
      'winguru' => 'place__widget_winguru',
      'gismeteo' => 'place__widget_gismeteo',
      'meteo' => 'place__widget_meteo-paraplan'
      ),
    // 'scripts' => '<script src="https://widget.windguru.cz/js/wg_widget.php" type="text/javascript"></script>' 
    'tplScriptWindguruData' => '<script>var windguruData = [%1$s];</script>'
  );

  $config = shortcode_atts($config, $atts, 'fly-places');

  $args = array
  (
    'sort_column'  => 'menu_order',
    'parent'       => $config['id']
  );

  $pages = get_pages($args);
  $chunkItemTabs = '';
  $chunkItemContents = '';
  $firstPlace = true;

  $windguruPlaces = [];
  
  foreach ($pages as $key => $post) 
  {
    setup_postdata($post);

    $activeTabClass = '';
    $activeContentClass = '';

    if($firstPlace) 
    {
      $activeTabClass = $config['activeTabClass'];
      $activeContentClass = $config['activeContentClass'];
      $firstPlace = false;
    };

    $widgets = '';
    foreach($config['widgets'] as $name => $widget)
    {
      if(get_field($widget))
      {
        if($widgets != '')
        {
          $widgets .= ','; 
        }
        else
        {
          $widgets .= '{';
        }
        $widgets .= '"' . $name . '":' . get_field($widget);
      }

      if ($name == 'winguru') {
        $windguruPlaceId = json_decode(get_field($widget))->s;
        $windguruPlaces[] = get_place($windguruPlaceId);
      }
    }
    $widgets .= '}';

    $chunkItemTabs .= sprintf($config['tplItemTab'], $activeTabClass, $post->post_name, $widgets, get_the_title());
    $chunkItemContents .= sprintf($config['tplItemContent'], $post->post_name, $activeContentClass, get_the_title(), get_the_content());
  }
  wp_reset_postdata();

  $windguruPlaces = join(',', $windguruPlaces);
  $windguruData = sprintf($config['tplScriptWindguruData'], $windguruPlaces);
  
  $flyPlaces = sprintf($config['tplWrap'], $chunkItemTabs, $chunkItemContents, $windguruData);

  return $flyPlaces;
}
add_shortcode('fly-places', 'fly_places');