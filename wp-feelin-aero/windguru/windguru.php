<?php
// error_reporting(E_ALL);

// Если ID спота не указан - выходим
if(empty($_GET['s'])) die('Need spot name!');

$spot = $_GET['s'];
$callback = $_GET['callback'];
$filename = join(DIRECTORY_SEPARATOR, array(getcwd(), "cache", $spot . ".txt"));
$contents = '';

// Если файл существует и он достаточно свеж - читаем
if(file_exists($filename))
{
  $handle = fopen($filename, 'r');
  $contents = fread($handle, filesize($filename));
  fclose($handle);
}

// Оборачиваем в cb функцию и отправляем
echo $callback . "(" . $contents . ")";