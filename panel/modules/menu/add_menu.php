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
$name = htmlentities($_POST['name']);
$link  = htmlentities($_POST['link']);
$icon = htmlentities($_POST['icon']);
$query = $page->sqlite_query('insert into menu_admin (name,link,icon) VALUES ("'.$name.'","'.$link.'","'.$icon.'")');
if($query == true){
    $success = 'Add menu successfully';
    //$java = 'location.reload();';
}else{
    $error = 'An error occurred. Can not add';
    $java = '$("#btn-auto").prop("disabled",false);';
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