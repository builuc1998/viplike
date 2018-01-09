<?php
session_start();
require_once('library/common.php');
$page = new core();
$page->setting();
$page->sqlite_create();
$page->create_main_html();
$meta = $page->sqlite_row('select * from meta');
foreach($meta as $m){
    if($m['type'] == 'description'){
        $page->rv('$description',$m['meta_value']);
    }if($m['type'] == 'title'){
        $page->rv('$title',$m['meta_value']);
    }if($m['type'] == 'image'){
        $page->rv('$image',$m['meta_value']);
    }if($m['type'] == 'keywords'){
        $page->rv('$keywords',$m['meta_value']);
    }if($m['type'] == 'url'){
        $page->rv('$url',$m['meta_value']);
    }
}
$page->rv('$sidebarmenu',$page->m('trangchu/sidebar_menu.php'));
$page->rv('$modal',$page->m('trangchu/modal.php'));
$page->rv('$account',$page->m('user/account.php'));

if($_GET['f'] == '' || !isset($_GET)){
    $page->rv('$noidung',$page->m('trangchu/home.php'));
}else{
    if(!isset($_SESSION['info'])){
        $page->rv('$noidung',$page->m('trangchu/home.php'));
    }else{
        if($_GET['f'] == 'autolike')$page->rv('$noidung',$page->m('auto/likes.php',1));
        if($_GET['f'] == 'autoreaction')$page->rv('$noidung',$page->m('auto/likes.php',2));
        if($_GET['f'] == 'autosub')$page->rv('$noidung',$page->m('auto/sub.php'));
        if($_GET['f'] == 'autodelstatus')$page->rv('$noidung',$page->m('auto/delstatus.php'));
        if($_GET['f'] == 'botlike')$page->rv('$noidung',$page->m('bot/likes.php'));
        if($_GET['f'] == 'botreactions')$page->rv('$noidung',$page->m('bot/reactions.php'));
    }
}
$page->create_template();
$page->show_html();
?>