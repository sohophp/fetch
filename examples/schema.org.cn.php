<?php
require '../bootstrap.php';

use Sohophp\Fetcher\Fetcher;

$url = 'https://schema.org.cn/';
$Response = Fetcher::get($url);
echo $Response;
