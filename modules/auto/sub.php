<?php
$page = new core();
$page->create_content('modules/auto/sub.html');
$page->rv('$str',$load);
$page->create_template();
return $page->content;
?>