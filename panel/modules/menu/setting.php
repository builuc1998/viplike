<?php
$page = new core();
$page->create_content('modules/menu/setting.html');
$menu = $this->sqlite_row('select * from menu_admin');
foreach($menu as $r){
    if($r['active'] == 1){
        $checked = 'checked';
    }else{
        $checked = '';
    }
    $row_arr[] = array($r['id'],$r['name'],$r['link'],$r['icon'],$checked);
}
$key_arr = array('$id','$name','$link','$icon','$checked');
$page->rl('',$key_arr,$row_arr);
$page->create_template();
return $page->content;
?>