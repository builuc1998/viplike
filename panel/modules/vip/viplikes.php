<?php
$config = include('../modules/config.php');
$page = new core();
$page->create_content('modules/vip/viplikes.html');
$menu = $this->sqlite_row('select * from viplike where type = "LIKE"');
if(sizeof($menu) > 0){
    foreach($menu as $r){
        if($r['active'] == 1){
            $checked = 'checked';
        }else{
            $checked = '';
        }
        $row_arr[] = array($r['id'],$r['uid'],$r['buy_time'],$r['time'].' Month',$checked,$r['username'],date('Y-m-d',strtotime($r['buy_time'] . '+'.$r['time'].' month')),$r['type'],$r['package'].' - ('.$config['vip'.$r['package']].' Like)');
    }   
}else{
    $message = 'There are currently no VIP IDs active';
    $page->rv('$display','display:none');
    $page->rv('$message',$message);
}
$key_arr = array('$id','$uid','$buy_time','$time','$checked','$manager','$expirationdate','$type','$package');
$page->rl('',$key_arr,$row_arr);
$page->create_template();
return $page->content;
?>