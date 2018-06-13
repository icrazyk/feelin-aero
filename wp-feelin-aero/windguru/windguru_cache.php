<?php
/*
Plugin Name: Windguru cache
Version: 0.1.0
*/

// error_reporting(E_ALL);

$config = [
  // Страницы родительские для страниц c windguru id`s
  'pages' => [
    1 => '234',
    2 => '1063',
  ],

  // Максимальное время выполнения скрипта
  'time_limit' => 300,

  // Задержка перед запросом очередного прогноза погоды
  'delay' => 5,

  'wp_core_path' => $_SERVER['HOME'] . '/feelin-aero.com/public_html/wp-load.php',

  'cache_path' => $_SERVER['HOME'] . '/feelin-aero.com/public_html/wp-content/themes/feelinaero/windguru/cache',
];

set_time_limit($config['time_limit']);

require($config['wp_core_path']);
require('phpQuery-onefile.php');

function get_web_page($url)
{
  $options = array(
    CURLOPT_RETURNTRANSFER => true,     // return web page
    CURLOPT_HEADER         => false,    // don't return headers
    CURLOPT_FOLLOWLOCATION => true,     // follow redirects
    CURLOPT_ENCODING       => "",       // handle all encodings
    CURLOPT_USERAGENT      => "spider", // who am i
    CURLOPT_AUTOREFERER    => true,     // set referer on redirect
    CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
    CURLOPT_TIMEOUT        => 120,      // timeout on response
    CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    CURLOPT_SSL_VERIFYPEER => false,     // Disabled SSL Cert checks
    CURLOPT_HTTPHEADER		 => ["Cookie: wgcookie=1|ms|c|m|3|22||102|forecast|74531_259602_334217_27754|||0|1|_;langc=ru-"],
  );

  $ch      = curl_init( $url );
  curl_setopt_array( $ch, $options );
  $content = curl_exec( $ch );
  $err     = curl_errno( $ch );
  $errmsg  = curl_error( $ch );
  $header  = curl_getinfo( $ch );
  curl_close( $ch );

  $header['errno']   = $err;
  $header['errmsg']  = $errmsg;
  $header['content'] = $content;
  return $header;
}

foreach ($config['pages'] as $pageId) 
{
  $args = [
    'sort_column'  => 'menu_order',
    'parent'       => $pageId,
  ];

  $pages = get_pages($args);

  foreach ($pages as $page)
  {
    $field = json_decode(get_field('place__widget_winguru', $page -> ID));
    $spotId = $field -> s;
    $filename = join(DIRECTORY_SEPARATOR, [$config['cache_path'], $spotId . ".txt"]);

    $json = [];

    $webPage = get_web_page('https://old.windguru.cz/ru/index.php?sc=' . $spotId)['content'];
  
    $document = phpQuery::newDocument($webPage);
    $scripts = $document->find('script');

    $patterns = [
      'lang' => '/WgLang = (\{.*\});/',
      'fcst' => '/fcst_tab_data_1 = (\{.*?\});/',
    ];

    foreach($scripts as $item)
    {
      $matches = [];
      $approved = false;
      $script = pq($item);
      $input = $script->html();

      foreach($patterns as $key => $pattern)
      {
        $approved = preg_match($pattern, $input, $matches);

        if($approved)
        {
          $json[$key] = json_decode($matches[1]);
        }
      }
    }
  
    // Если страница содержит информацию о споте - пишем её в файл
    if(count($json) == 2)
    {
      $contents = json_encode($json);
      $handle = fopen($filename, "w+");
      fwrite($handle, $contents);
      fclose($handle);

      sleep(5);
    }
  }
}
