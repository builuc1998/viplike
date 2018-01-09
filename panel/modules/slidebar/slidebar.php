<?php
$page = new core();
$page->create_content('modules/slidebar/slidebar.html');
$row = $this->sqlite_row('select * from menu_auto order by xuatban desc');
if(sizeof($row) > 0){
    foreach($row as $r){
        if($r['xuatban'] == 1){
            $checked = 'checked="checked"';
        }else{
            $checked = '';
        }
        $row_arr[] = array(html_entity_decode($r['ten']),html_entity_decode($r['link']),html_entity_decode($r['icon']),$checked,$r['id']); 
    }
}
$key_arr = array('$name','$link','$icon','$check','$id');
$page->rl('',$key_arr,$row_arr);

$page->create_template();
return $page->content;
?>