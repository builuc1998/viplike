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
$email = htmlentities($_POST['email']);
$password = md5($_POST['password']);
$row = $page->sqlite_single_row('select * from admin where username = "'.$username.'"');
$row2 = $page->sqlite_single_row('select * from admin where email = "'.$email.'"');
if(sizeof($row) > 0){
    $error = 'The '.$username.' account is already in the system. can not add';
    $java = "$('#username').css({'border':'1px solid red'});";
}else if(sizeof($row2) > 0){
    $error = 'The '.$email.' account is already in the system. can not add';
    $java = "$('#email').css({'border':'1px solid red'});";
}else{
    $sql = 'insert into admin (username,password,email) VALUES ("'.$username.'","'.$password.'","'.$email.'")';
    $query = $page->sqlite_query($sql);
    if($query2 == true){
        $success = 'Successful';
        $java = 'location.reload();';
    }else{
        $error = 'Registration failed';
    }
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