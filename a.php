<?php
require_once('library/common.php');
$page=new core();
$page->setting();
$page->sqlite_create();
$id = file_get_contents_curl('https://graph.facebook.com/me/accounts?access_token=EAAAAUaZA8jlABANMjwmZAp2lqQOF5QdsjRhOxHyHW2pBW4lVuUgAiLPKOzLoZCBmY8ZBlAAC6QCleZBZCg5t8ZBcczxD0ZA6E9QzSC6JAZBHhNQuRndyULuZAnb4VcISd5kNdZB2yc7FJIa1P0dqlK4ENv3ELxZArrVIbhH7pT2ibQf3vQZDZD');
foreach($id['data'] as $r){
    echo $r['access_token'].'<br />';
}
?>