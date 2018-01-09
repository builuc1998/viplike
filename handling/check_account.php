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
if($_POST['check'] == 1){
    $username = str_replace(" ","",$_POST['username']);
    $sql = 'select * from account where username = "'.$username.'"';
    $text = 'Username';
}
if($_POST['check'] == 2){
    $email = str_replace(" ","",$_POST['email']);    
    $sql = 'select * from account where email = "'.$email.'"';
    $text = 'Email';
}
$row = $page->sqlite_single_row($sql);
echo sizeof($row);
if(sizeof($row) > 0){
    $error = $text.' đã có người sử dụng';
    $java =  '$("#'.$_POST['elm'].'").css({"border":"1px solid red"});return false;';
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