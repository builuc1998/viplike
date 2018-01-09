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
require_once('../library/common.php');
$page=new core();
$page->setting();
$page->sqlite_create();
$link = $_POST['link'];
$message = $_POST['message'];
$limit = $_POST['limit'];
if($limit > 50){
    $res = 'Số lượng tối đa 50 share. Vui lòng thử lại';
}else{
    $row = $page->sqlite_row('select * from token where live = 1 and loai = "page"');
    foreach($row as $r){
        $token[] = $r['token'];
    }
    for($i = 0 ; $i < $limit ; $i++){
        $a = $page->buffshare($token[array_rand($token,1)],$link,$message);
    }
    $res = 'Auto kết thúc';
}

?> 
	 
	 ]]>
  </data>
  <java><![CDATA[
        $.notify("<?=$res?>", "success");
        $('#btn-auto').prop('disabled',false);  
        <?=$java?>
	  ]]>
  </java>
</root>