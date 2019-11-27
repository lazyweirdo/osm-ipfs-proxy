<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$ttl = 14 * 24 * 60 * 60; //cache timeout in seconds

$x = intval($_GET['x']);
$y = intval($_GET['y']);
$z = intval($_GET['z']);

$path = "tiles/mapnik/${z}/${x}";
$file = "${path}/${y}.json";

$cid = false;

$isFile = is_file($file);
if ($isFile) {
	$content = file_get_contents($file);
	$json = json_decode($content, true);
	if ($json) {
		$cid = $json["cid"];
	}
}

$add = !$cid or filemtime($file) < (time() - $ttl);
if ($add) {
	if (!is_dir($path)) {
		mkdir($path, 0777, true);
	}

	$url = "http://pulsartronic.duckdns.org/ipfstile.php?x=$x&y=$y&z=$z";
	$ch = curl_init($url);
	$fp = fopen($file, "w");
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fflush($fp);
	fclose($fp);
}

$exp_gmt = gmdate("D, d M Y H:i:s", time() + $ttl) ." GMT";
$mod_gmt = gmdate("D, d M Y H:i:s", filemtime($file)) ." GMT";
header("Expires: " . $exp_gmt);
header("Last-Modified: " . $mod_gmt);
header("Cache-Control: public, max-age=" . $ttl); 

readFile($file);

?>
