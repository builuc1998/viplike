<?php

require_once('library/common.php');

$page = new core();

$page->setting();

$page->sqlite_create();

$row = $page->sqlite_row('select * from token where live = 1');

$live = 0;

$die = 0;

$jslive = $jsdie = '';

foreach($row as $r){

    $a = check_token_live($r['token']);

    if($a['id']){

        $live++;

    }else{

        $die++; 

        $page->sqlite_query('update token set live = 0 where id = '.$r['id']);

        $jslive[] = array(

        "token" => $r['token'],

        "UID" => $r['uid']

        );       

    }

}

//echo json_encode($jslive);

echo 'Live: '.$live.'<br />';

echo 'Die: '.$die;

?>