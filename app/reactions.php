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
$id = $_POST['id'];
$camxuc = $_POST['camxuc'];
$row = $page->sqlite_row('select * from token');
foreach($row as $r){
    $a = $page->reactions($id,$camxuc,$r['token']);    
}
//var_dump($a);
?> 

	 ]]>
  </data>
  <java><![CDATA[
        <?=$java?>
	  ]]>
  </java>
</root>