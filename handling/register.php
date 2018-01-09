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
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$fullname = $_POST['fullname'];
$fullname = $_POST['uid'];
$row_user = $page->sqlite_single_row('select username from account where username = "'.$username.'"');
$row_mail = $page->sqlite_single_row('select email from account where email = "'.$email.'"');
if(sizeof($row_user) > 0){
    
}if(sizeof($row_user) > 0){
    $error = 'Username đã có người sử dụng';
    $java =  '$("#username_reg").css({"border":"1px solid red"});';
}else if(sizeof($row_mail) > 0){
    $error = 'Email đã có người sử dụng';
    $java =  '$("#email_reg").css({"border":"1px solid red"});';
}else if(strlen($username) < 5){
    $java = "$('#username_reg').css({'border':'1px solid red'});";
    $error = 'Tên đăng nhập phải từ 6 ký tự trở lên và không chứa dấu cách(space)';
}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $java = '$("email_reg").css({"border":"1px solid red"});';
    $error = 'Vui lòng nhập Email hợp lệ';
}else if(strlen($password) < 5){
    $java = '$("#password").css({"border":"1px solid red"});';
    $error = 'Mật khẩu phải từ 6 ký tự trở lên và không chứa dấu cách(space)';
}else if(strlen($phone) < 5){
    $java = '$("#phone").css({"border":""1px solid red"});';
    $error = 'Vui lòng nhập số điện thoại';
}else if(strlen($fullname) < 5){
    $java = "$('#fullname').css({'border':'1px solid red'});";
    $error = 'Vui lòng nhập Họ Tên';
}
if(sizeof($error) < 1){
    $password = md5($password);
    $fullname = htmlentities($fullname);
    $email = htmlentities($email);
    $phone = htmlentities($phone);
    $username = htmlentities($username);
    $uid = htmlentities($_POST['uid']);
    $sql = 'insert into account (username,email,password,phone,datejoin,fullname,uid) VALUES ("'.$username.'","'.$email.'","'.$password.'","'.$phone.'","'.time().'","'.$fullname.'","'.$uid.'")';
    $query = $page->sqlite_query($sql);
    if($query == true){
        $success = 'Đang chuyển hướng....';
        $java = 'LoadXmlDocPost("/handling/vn/login_account.php","username='.html_entity_decode($username).'&password='.$password.'");';
    }else{
        $error = 'Đăng ký không thành công....");';
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