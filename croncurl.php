<?php
$url = '202.9.90.21/curl/curl1.php';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$result = curl_exec($ch);
curl_close($ch);