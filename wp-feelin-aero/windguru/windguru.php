<?php
// error_reporting(E_ALL);

// Если ID спота не указан - выходим
if(empty($_GET['s'])) die('Need spot name!');

require_once 'phpQuery-onefile.php';
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
    CURLOPT_HTTPHEADER		 => array("Cookie: wgcookie=1|ms|c|m|3|22||102|forecast|74531_259602_334217_27754|||0|1|_;langc=ru-")
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

$spot = $_GET['s'];
$callback = $_GET['callback'];
$filename = join(DIRECTORY_SEPARATOR, array(getcwd(), "cache", $spot . ".txt"));

// Если файл существует и он достаточно свеж - читаем
if(file_exists($filename) && ((time() - filemtime($filename)) < 600))
{
  $handle = fopen($filename, 'r');
  $contents = fread($handle, filesize($filename));
  fclose($handle);
}
// Иначе запрашиваем актуальные данные на сайте
else
{
  $json = array();
  $hbr = array(
    'lang' => get_web_page('https://old.windguru.cz/ru/index.php?sc=' . $spot)['content'],
    'fcst' => get_web_page('https://old.windguru.cz/ru/index.php?sc=' . $spot)['content'],
  );

  foreach ($hbr as $hb)
  {
    $document = phpQuery::newDocument($hb);
    $scripts = $document->find('script');

    $patterns = array(
      'lang' => '/WgLang = (\{.*\});/',
      'fcst' => '/fcst_tab_data_1 = (\{.*?\});/'
    );

    foreach($scripts as $item)
    {
      $matches = array();
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
  }


  // Если страница содержит информацию о споте - пишем её в файл
  if($json['fcst'])
  {
    $contents = json_encode($json);
    $handle = fopen($filename, "w+");
    fwrite($handle, $contents);
    fclose($handle);
  }
}

// Оборачиваем в cb функцию и отправляем
echo $callback . "(" . $contents . ")";