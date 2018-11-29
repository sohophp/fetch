<?php
require '../bootstrap.php';
use Sohophp\Fetcher\Fetcher;

$url = 'https://www.baidu.com/';
$Response = Fetcher::get($url);
echo $Response;
