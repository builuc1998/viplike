<?php
session_start();
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<root>
<data><![CDATA[
<?php 
require_once('../library/common.php');
$page=new core();
$page->setting();
$page->sqlite_create();
$username = str_replace(" ","",$_POST['username']);
$password = str_replace(" ","",md5($_POST['password']));
$row = $page->sqlite_single_row('select * from account where username ="'.$username.'" and password = "'.$password.'"');
echo sizeof($row) > 0;
if(sizeof($row) > 0){
    $_SESSION['info'] = $row;
    $success = 'Đang chuyển hướng';
    $java = 'setTimeout(function(){
        location.reload();
    },3000)';
}else{
    $error = 'Tài khoản hoặc mật khẩu không chính xác';
}
?> 	 
	 ]]>
  </data>
  <java><![CDATA[
    <?php
        if(sizeof($error) > 0){
            echo 'toastr.error("'.$error.'");';
        }
        if(isset($success) > 0){
            echo 'toastr.success("'.$success.'");';
        }
    ?>
    <?=$java?>
	  ]]>
  </java>
</root>