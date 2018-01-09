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
$limit = $_POST['limit'];
$id = file_get_contents_curl('https://graph.facebook.com/me/feed?fields=type&limit='.$limit.'&access_token='.$_SESSION['token']);
foreach($id['data'] as $r){
    echo 'https://graph.facebook.com/'.$r['id'].'?access_token='.$_SESSION['token'];
    $java .= 'js_curl("https://graph.facebook.com/'.$r['id'].'?access_token='.$_SESSION['token'].'","DELETE");';
    //var_dump(curl('https://graph.facebook.com/'.$r['id'].'?access_token='.$_SESSION['token'],'DELETE'));
}
$res = 'Auto kết thúc';
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