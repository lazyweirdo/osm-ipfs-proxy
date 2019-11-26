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

	$rnd = uniqid();
	$tempfile = "tiles/mapnik-${z}-${x}-${y}-${rnd}.png";

	$server = array();
	$server[] = 'a.tile.openstreetmap.org';
	$server[] = 'b.tile.openstreetmap.org';
	$server[] = 'c.tile.openstreetmap.org';

	$url = 'http://'.$server[array_rand($server)]."/".$z."/".$x."/".$y.".png";;

	$ch = curl_init($url);
	$fp = fopen($tempfile, "w");
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fflush($fp);    // need to insert this line for proper output when tile is first requestet
	fclose($fp);

	$hash = exec("export IPFS_PATH=/home/pulsartronic/.ipfs; ipfs add $tempfile -q");
	unlink($tempfile);

	$time = time();
	$content = '{"cid": "'.$hash.'","update":"'.$time.'"}'; // get hash
	if (!is_dir($path)) {
		mkdir($path, 0777, true);
	}
	file_put_contents($file, $content);

	$cid = !$cid ? $hash : $cid;
	// TODO:: check and unpin old hash
}

$exp_gmt = gmdate("D, d M Y H:i:s", time() + $ttl) ." GMT";
$mod_gmt = gmdate("D, d M Y H:i:s", filemtime($file)) ." GMT";
header("Expires: " . $exp_gmt);
header("Last-Modified: " . $mod_gmt);
header("Cache-Control: public, max-age=" . $ttl); 

readFile($file);

?>
