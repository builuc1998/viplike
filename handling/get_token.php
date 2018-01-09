<?php
session_start();
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<root>
  <data><![CDATA[
<?php 


header('Origin: https://facebook.com');
define('API_SECRET', 'c1e620fa708a1d5696fb991c1bde5662');
define('BASE_URL', 'https://api.facebook.com/restserver.php');

function sign_creator(&$data){
	$sig = "";
	foreach($data as $key => $value){
		$sig .= "$key=$value";
	}
	$sig .= API_SECRET;
	$sig = md5($sig);
	return $data['sig'] = $sig;
}
if(isset($_POST['username'], $_POST['password'])){
	$_GET = $_POST;
}
$data = array(
	"api_key" => "3e7c78e35a76a9299309885393b02d97",
	"credentials_type" => "password",
	"email" => @$_GET['username'],
	"format" => "JSON",
	"generate_machine_id" => "1",
	"generate_session_cookies" => "1",
	"locale" => "en_US",
	"method" => "auth.login",
	"password" => @$_GET['password'],
	"return_ssl_resources" => "0",
	"v" => "1.0"
);
sign_creator($data);
echo '<iframe width="100%" id="hihi" height="100%" src="https://api.facebook.com/restserver.php?'.http_build_query($data).'"></iframe>';

?> 	 
	 ]]>
  </data>
  <java><![CDATA[
        $('#btn-auto').prop('disabled',false);
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