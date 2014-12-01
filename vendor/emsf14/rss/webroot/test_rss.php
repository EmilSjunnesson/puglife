<?php
require '../src/library/CRSS.php';

$feed = new \Emsf14\library\CRSS([
	'http://feeds.bbci.co.uk/news/rss.xml'
]);
?>

<!doctype html>
<meta charset=utf8>
<title>RSS Example</title>
<h1>RSS Example</h1>
<?=$feed->printFeed()?>