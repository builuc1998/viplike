<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
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

$token = $_POST['token'];

$a = check_token($token);

//var_dump($a);

if($a['id']){

    $res = '';

    $_SESSION['name'] = $a['name'];

    $_SESSION['id'] = $a['id'];

    $_SESSION['token'] = $token;

    $java .= 'location.reload();';

}else{

    $res2 = $a['error']['message'];

    if($res2){

        $res = 'alert("Token không hợp lệ: '.$res2.'");';

    }

}

    $java.='$("#btnlogin").html("<span id=\'btnlogin\'><i class=\'fa fa-sign-in\'></i></span>");

    $(\'.addon-login\').removeClass(\'text-btnlogin\');';

    //alert("$a");    

?> 

	 

	 ]]>

  </data>

  <java><![CDATA[

        

        <?=$java?>

        <?=$res?>

	  ]]>

  </java>

</root>