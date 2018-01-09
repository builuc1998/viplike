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
$id = $_SESSION['id'];
$noidung = $_POST['noidung'];
$idpost = $_POST['id'];
@file_put_contents('../data/botuptop/'.$id,$noidung);
$row = $page->sqlite_single_row('select * from botuptop where thanhvien = '.$id);
if(sizeof($row) > 0){
    $sql = 'delete from botuptop where thanhvien ='.$id;
    $bot = 0;
    $res = 'Gỡ BOT thành công';       
}else{
    echo $sql = 'insert into botuptop (thanhvien,post,noidung,thoigian) VALUES ('.$id.',"'.htmlentities($idpost).'","'.htmlentities($noidung).'","'.time().'")';
    $bot = 1;
    $res = 'Cài BOT thành công';       
}
    echo $sql = 'insert into botuptop (thanhvien,post,noidung,thoigian) VALUES ('.$id.',"'.htmlentities($idpost).'","'.htmlentities($noidung).'","'.time().'")';
$is = $page->sqlite_query($sql);
if($is == true){
    $java = 'setTimeout(function(){
        location.reload();
    },2000);';
}else{
    $res = 'Lỗi chưa thể cài BOT';
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