<?php

header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Cache-Control: post-check=0, pre-check=0", false);


$html =
"<!DOCTYPE html>
<html lang=\"de\">
  <head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
	<meta http-equiv=\"cache-control\" content=\"no-cache\" />
	<meta http-equiv=\"pragma\" content=\"no-cache\" />
	<meta	http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	<link	rel=\"stylesheet\" type=\"text/css\" href=\"lib/style.css\" />
  <link rel=\"stylesheet\" href=\"https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css\">
	<script	src=\"lib/lib.js\" type=\"text/javascript\"></script>
	<script	src=\"lib/jquery.js\" type=\"text/javascript\"></script>
	<script	src=\"lib/jquery.tablesorter.min.js\" type=\"text/javascript\"></script>
	<script type=\"text/javascript\">
	$(function() {
	$(document).ready(function() {  $(\".belegTabelle\").tablesorter( {
               // enable debug mode
               //debug: false;
           } );  } );	});
	</script>
  <title>Belegliste</title>
  </head>
  <body>"
?>