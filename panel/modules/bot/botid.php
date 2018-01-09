<?php
$page = new core();
$page->create_content('modules/bot/botid.html');
$menu = $this->sqlite_row('select * from botlike');
if(sizeof($menu) > 0){
    foreach($menu as $r){
        if($r['active'] == 1){
            $checked = 'checked';
        }else{
            $checked = '';
        }
        $row_arr[] = array($r['id'],$r['uid'],$r['type'],$r['username'],$checked);
    }   
}else{
    $message = 'There are currently no VIP IDs active';
    $page->rv('$display','display:none');
    $page->rv('$message',$message);
}
$key_arr = array('$id','$uid','$type','$username','$checked');
$page->rl('',$key_arr,$row_arr);
$page->create_template();
return $page->content;
?>