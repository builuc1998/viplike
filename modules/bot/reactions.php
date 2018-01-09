<?php
$page = new core();
$page->create_content('modules/bot/reactions.html');
$row = $this->sqlite_row('select * from botlike where type != "LIKE" and username = "'.$_SESSION['info']['username'].'"');
if(sizeof($row) > 0){
    foreach($row as $r){
        if($r['active'] == 1){
            $checked = 'checked';
        }else{
            $checked = '';
        }
        $row_arr[] = array($r['uid'],$r['username'],$r['type'],$checked); 
    }
}else{
    $message = 'No BOT Reactions ID is installed';
    $page->rv('$display','display:none');
    $page->rv('$message',$message);
}
$key_arr = array('$uid','$username','$type','$checked');
$page->rl('',$key_arr,$row_arr);
$page->create_template();
return $page->content;
?>