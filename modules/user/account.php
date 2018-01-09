<?php
$page = new core();
if(isset($_SESSION['id'])){
    $page->create_content('modules/user/account_login.html');    
}else{
    $page->create_content('modules/user/account.html');
}
$page->rv('$name',html_entity_decode($_SESSION['info']['fullname']));
$page->rv('$email',html_entity_decode($_SESSION['info']['email']));
$page->rv('$phone',html_entity_decode($_SESSION['info']['phone']));
$page->rv('$datejoin',date("d-m-Y",$_SESSION['info']['datejoin']));
$page->rv('$monney',$_SESSION['info']['monney']);
$page->create_template();
return $page->content;
?>