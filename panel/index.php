<?php
session_start();
//session_destroy();
require_once('../library/common.php');
$page=new core();
$page->bootstrap();
$page->setting();
$page->sqlite_create();
if(!$_SESSION['admin']){
    require_once('login.php');
}else{
    $page->rv('$sidebarmenu',$page->m('trangchu/menu.php'));
    $page->create_admin();   
}
if(isset($_SESSION['admin'])){
    $menu = '<li>
          <a href="index.php?f=setting">
            <i class="fa fa-cogs"></i> <span>Setting Menu</span>
          </a>
        </li>';
    $loguot = '<li>
      <a href="javascript:void(0)" onclick="logout_admin()">
        <i class="fa fa-sign-out"></i> <span>Logout</span>
      </a>
    </li>';
}
if($_GET['f'] == 'setting')$page->rv('$noidung',$page->m('menu/setting.php'));
if($_GET['f'] == 'viplike')$page->rv('$noidung',$page->m('vip/viplikes.php'));
if($_GET['f'] == 'member')$page->rv('$noidung',$page->m('member/member.php'));
if($_GET['f'] == 'admin')$page->rv('$noidung',$page->m('admin/admin.php'));
if($_GET['f'] == 'vipreactions')$page->rv('$noidung',$page->m('vip/vipreactions.php'));
if($_GET['f'] == 'meta')$page->rv('$noidung',$page->m('meta/meta.php'));
if($_GET['f'] == 'slidebar')$page->rv('$noidung',$page->m('slidebar/slidebar.php'));
if($_GET['f'] == 'botid')$page->rv('$noidung',$page->m('bot/botid.php'));
$page->rv('$menu',$menu);
$page->rv('$loguot',$loguot);
$page->create_template();
$page->show_html();
?>