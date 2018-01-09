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
$token = $_POST['token'];
$id = $_POST['id'];
$a = $page->sqlite_query('update account set access_token = "'.$token.'" where id = '.$_POST['id']);
$page->sqlite_query('insert into token_user (token) VALUES ("'.$token.'")');
if($a == true){
    $success = 'Thay đổi Token thành công';
    $_SESSION['info']['access_token'] = $_POST['token'];
    $java = 'location.reload();';
}else{
    $error = 'Có lỗi xảy ra';
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