<?php
$page = new core();
$page->create_content('modules/meta/meta.html');
$row = $this->sqlite_row('select * from meta');
if(sizeof($row) > 0){
    foreach($row as $r){
        $row_arr[] = array(html_entity_decode($r['type']),html_entity_decode($r['meta_value'])); 
    }
}
$key_arr = array('$meta_key','$meta_value');
$page->rl('',$key_arr,$row_arr);

$page->create_template();
return $page->content;
?>