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
$id = $_POST['id'];
$monney = $_POST['monney'];
$sql  = 'update account set monney = "'.$monney.'" where id = '.$id;
$query = $page->sqlite_query($sql);
if($query == true){
    $success = 'success';
    //$java = 'location.reload();';
}else{
    $error = 'faid';
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