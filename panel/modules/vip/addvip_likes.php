<?php
session_start();
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<root>
<data><![CDATA[
<?php 
require_once('../../../library/common.php');
$page=new core();
$page->setting();
$page->sqlite_create();
$username = htmlentities(str_replace(" ","",$_POST['username']));
$total = (int)$_POST['total'];
$time = htmlentities($_POST['time']);
$uid = htmlentities($_POST['uid']);
$type = htmlentities($_POST['type']);
$buy_time = date('Y-m-d',time());
$goi = htmlentities($_POST['goi']);

$row = $page->sqlite_single_row('select * from account where username = "'.$username.'"');
if(sizeof($row) > 0){
    echo 'select * from viplike where uid = "'.$uid.'" and active = 1';
    $check_vip = $page->sqlite_single_row('select * from viplike where uid = "'.$uid.'" and active = 1');
    if(sizeof($check_vip)  < 1){
        if($row['monney'] < $total){
            $error = 'Existing amount is not enough to register';
        }else{
            $sql = 'insert into viplike (uid,buy_time,time,username,type,package) VALUES ("'.$uid.'","'.$buy_time.'","'.$time.'","'.$username.'","'.$type.'","'.$goi.'")';
            $query = $page->sqlite_query($sql);
            if($query == true){
                $monney = $row['monney'] - $total;
                $page->sqlite_query('update account set monney = '.$monney.' where username = "'.$username.'"');
                $success = 'Successful VIP ID registration';
                $java = 'location.reload();';
            }else{
                $error = 'Registration failed';
            }
        }
    }else{
        $check_vip2 = $page->sqlite_single_row('select * from viplike where uid = "'.$uid.'" and active = 0');
        if(sizeof($check_vip2) > 0){
            if($row['monney'] < $total){
                $error = 'Existing amount is not enough to register';
            }else{
                $sql2 = 'update viplike set type = "'.$type.'", time = "'.$time.'",buy_time = "'.$buy_time.'",active = 1,username = "'.$username.'",package = "'.$goi.'" where uid = "'.$uid.'"';
                $query2 = $page->sqlite_query($sql2);
                if($query2 == true){
                    $monney = $row['monney'] - $total;
                    $page->sqlite_query('update account set monney = '.$monney.' where username = "'.$username.'"');
                    $success = 'Successful VIP ID registration';
                    $java = 'location.reload();';
                }else{
                    $error = 'Registration failed';
                }
            }
        }else{
            $error = html_entity_decode($uid).' has been registered.';
        }

    }
}else{
    $error = html_entity_decode($username).' not in the system.';
}

?> 	 
	 ]]>
  </data>
  <java><![CDATA[
    <?php
        echo $java;
        if(sizeof($error) > 0){
            echo 'toastr.error("'.$error.'");';            
        }
        if(isset($success) > 0){
            echo 'toastr.success("'.$success.'");';
        }
    ?>
	  ]]>
  </java>
</root>