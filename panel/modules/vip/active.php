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
$uid = htmlentities($_POST['uid']);

$row = $page->sqlite_single_row('select * from viplike where uid = "'.$uid.'"');
if($row['active'] == 1){
    $act = 0;
}else{
    $act = 1;
}
$query = $page->sqlite_query('update viplike set active ='.$act.' where uid = "'.$uid.'"');
if($query == true){
    $success = 'Successfully';
    $java = 'location.reload();';
}else{
    $error = 'Failed';
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