<?php
session_start();
$page = new core();
$page->setting();
$page->sqlite_create();
$page->create_content('modules/trangchu/menu.html');
$menu = $this->sqlite_row('select * from menu_admin where active = 1');
foreach($menu as $m){
    $str .= '<li>
              <a href="'.$m['link'].'">
                <i class="fa '.$m['icon'].'"></i> <span>'.$m['name'].'</span>
              </a>
            </li>';
}
$page->rv('$str',$str);
$page->create_template();
return $page->content;
?>