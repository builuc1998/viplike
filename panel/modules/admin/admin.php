<?php
$page = new core();
$page->create_content('modules/admin/admin.html');
$account = $this->sqlite_row('select * from admin');
if(sizeof($account) > 0){
    foreach($account as $r){
        if($_SESSION['admin']['id'] == 1){
            $change = '<input type="text" id="pass_'.$r['id'].'" onchange="changepass(\''.$r['id'].'\')"';
        }
        if($r['active'] == 1){
            $check = 'checked="checked"';
        }else{
            $check = '';
        }
        $row_arr[] = array($r['id'],$r['username'],$r['email'],$check,$change);
    }
}else{
    $message = 'There are no admin';
    $page->rv('$display','display:none');
    $page->rv('$message',$message);
}
$key_arr = array('$id','$name','$email','$check','$change');
$page->rl('',$key_arr,$row_arr);
$page->create_template();
return $page->content;
?>