<?php
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$ttl = 14 * 24 * 60 * 60; //cache timeout in seconds

$exp_gmt = gmdate("D, d M Y H:i:s", time() + $ttl) ." GMT";
$mod_gmt = gmdate("D, d M Y H:i:s", time()) ." GMT";
header("Expires: " . $exp_gmt);
header("Last-Modified: " . $mod_gmt);
header("Cache-Control: public, max-age=" . $ttl); 

$x = intval($_GET['x']);
$y = intval($_GET['y']);
$z = intval($_GET['z']);

// configure your own
$url = "http://pulsartronic.duckdns.org/ipfstile.php?x=$x&y=$y&z=$z";

$ch = curl_init();
$optArray = array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true
);
curl_setopt_array($ch, $optArray);
$result = curl_exec($ch);

echo $result;
?>
