<?php

define('MAGPIE_DIR', './magpie/');
define('MAGPIE_CACHE_DIR', './magpie/cache/');

require_once MAGPIE_DIR . 'rss_fetch.inc';

//TODO: Make this load from an external file
$rss[1] = "http://www.flickr.com/services/feeds/photos_public.gne?id=61143979@N00&format=rss_200";
$rss[2] = "http://news.google.com/nwshp?tab=wn&topic=t&output=rss&ned=:ePkh8BM9ExLVElTyy8xLVfDMS85Q8EvMzClWMmCE24Vmfyrc_gyw_TCrAfDiDL4";

if ($rss[$_GET['url']]) {
	$feed = fetch_rss($rss[$_GET['url']]);
	ob_start();
	echo '<div class="feedwidget_' . $_GET['url'] . '">';
	$count = 1;
	foreach ($feed->items as $item) {
		if ($count <= $_GET['limit']) {
			@include($_GET['url'] . '.inc');
		}
		$count++;
	}
	echo "</div>";
	$output = ob_get_contents();
	ob_end_clean();
	echo ($rss[$_GET['js']] ? "document.write('" : "") . 
		str_replace(array("\n", "\t", "'"), array("", "", "\'"), $output) . 
		($rss[$_GET['js']] ? "');" : "");
} else {
	echo "Invalid Url <br />";
}
?> 
