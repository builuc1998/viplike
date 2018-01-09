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
echo $id = $_SESSION['id'];
$row = $page->sqlite_single_row('select * from token where uid = '.$id);
if($row['bot_likes'] == 1){
    $bot = 0;
    $res = 'Gỡ BOT thành công';   
}else{
    $bot = 1;
    $res = 'Cài BOT thành công';   
}
$is = $page->sqlite_query('update token set bot_likes = "'.$bot.'" where uid = '.$id);
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