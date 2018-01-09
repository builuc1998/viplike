<?php
//var_dump($_SESSION);
$page = new core();
if($option == 1){
    $page->create_content('modules/auto/likes.html');    
}if($option == 2){
    $page->create_content('modules/auto/reactions.html');    
}   
$load = load_post($_SESSION['info']['access_token']);
$page->rv('$str',$load);
$page->create_template();
return $page->content;
?>