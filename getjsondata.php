#!/usr/bin/env php
<?php

if (empty($_SERVER['argv'][2])) die("NO URL/KEY\n");

$url = $_SERVER['argv'][1];
$key = $_SERVER['argv'][2];

$urlcheck = parse_url($url);
if (empty($urlcheck['host']) or empty($urlcheck['scheme'])) die("invalid url\n");

$ctx = stream_context_create([ 'http' => [ 'timeout' => 5 ]]);
$urldata = file_get_contents($url, 0, $ctx);

if ($urldata === false) die("invalid response\n");

$json = json_decode($urldata, true);
$traverses = explode('.', $key);
foreach ($traverses as $traverse) {
	if (!isset($json[$traverse])) die("no such key ".$key);
	$json = $json[$traverse];
}
echo $json;
