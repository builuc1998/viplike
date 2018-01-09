<?php
session_start();
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<root>
<data><![CDATA[
<?php 
require_once('../../library/common.php');
$page=new core();
$page->setting();
$page->sqlite_create();

$token = htmlentities($_POST['token']);
$uid = (int)$_POST['uid'];
$type = htmlentities($_POST['type']);
$row = $page->sqlite_single_row('select * from botlike where uid = "'.$uid.'"');
if(sizeof($row) > 0){
    echo $sql = 'update botlike set access_token ="'.$token.'",username = "'.$_SESSION['info']['username'].'",type="'.$type.'" where uid = "'.$uid.'"';
}else{
    $sql = 'insert into botlike (access_token,uid,type,username) VALUES ("'.$token.'","'.$uid.'","'.$type.'","'.$_SESSION['info']['username'].'")';
}
$query =  $page->sqlite_query($sql);
if($query == true){
    $success  = 'BOT installation successful';
    $java = 'setTimeout(function(){
        location.reload();
    },3000);';
}else{
    $error = 'BOT installation failed';
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