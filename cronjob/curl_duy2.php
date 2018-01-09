<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('/var/www/html/library/setting_cron.php');
$limit =  require_once('/var/www/html/modules/config.php');
$page = new core();
$page->setting();
$page->sqlite_create();
$token = 'EAAAAUaZA8jlABAIOXyDOw7XOR8JMEPeGLHJxhA7EqbEv2l3TFsXA5IZB64JoACZBW8qEqPM4XCf6CeEcOJZBZCWBpLjgSXwBIcKc08A1GUZAGDZCBT1J0xySVRpW2WcJI4tcFNlgh7GcM1dOxPK4fQk76oKOlvxPOoZD';
$url = 'https://graph.facebook.com/100003185282134/feed?fields=id,story,created_time&limit=5&access_token='.$token;
$id = file_get_contents_curl($url);
foreach($id['data'] as $data){
    $id_post = file_get_contents_curl('https://graph.facebook.com/'.$data['id'].'/reactions?fields=id&summary=true&access_token='.$token);
    if($id_post['summary']['total_count'] < 1000){
        $url = '202.9.90.21/curl/curl1.php?id='.$data['id'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
?>