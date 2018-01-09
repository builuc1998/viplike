<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
session_start();
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<root>
  <data><![CDATA[
<?php 
require_once('library/common.php');
$page=new core();
$page->setting();
$page->sqlite_create();
$token = $_POST['token'];
$a = $page->sqlite_query('delete from token where token = "'.$token.'"');
echo 'die';
?> 	 
	 ]]>
  </data>
  <java><![CDATA[
        <?=$java?>
        <?=$res?>
	  ]]>
  </java>
</root>