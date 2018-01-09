<?php
$page = new core();
$page->create_content('modules/member/member.html');
$account = $this->sqlite_row('select * from account');
if(sizeof($account) > 0){
    foreach($account as $r){
        if($_SESSION['admin']['id'] == 1){
            $onchange =  'onchange="addmonney('.$r['id'].')"'; 
            $disable = '';    
        }else{
            $disable = 'disabled="disabled"';
        }
        $vip = $this->sqlite_single_row('select COUNT(*) as C from viplike where username = "'.$r['username'].'"');
        $bot = $this->sqlite_single_row('select COUNT(*) as C from botlike where username = "'.$r['username'].'"');
        $row_arr[] = array($r['id'],$r['username'],$r['email'],$r['monney'],$r['uid'],$vip['C'].' - ID',$vip['C'].' - ID',$onchange,$disable);
    }
}else{
    $message = 'There are no members';
    $page->rv('$display','display:none');
    $page->rv('$message',$message);
}
$key_arr = array('$id','$name','$email','$monney','$uid','$vipid','$botid','$onchange','$disable');
$page->rl('',$key_arr,$row_arr);
$page->create_template();
return $page->content;
?>