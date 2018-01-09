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

$limit = $_POST['limit'];

$message = $_POST['message'];

$row = $page->sqlite_row('select * from token where live = 1 order by RANDOM() limit '.$limit);

foreach($row as $r){

    $message2 = explode('|',$message);

    if(sizeof($message2) > 1){

        $message2 = $message2[array_rand($message2,1)];

    }else{

        $message2 = $message;

    }

    $page->Addcomments($id,$message2,$r['token']);    

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