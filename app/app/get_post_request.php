<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();*/
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<root>
  <data><![CDATA[
<?php 
require_once('../library/common.php');
$page=new core();
$page->setting();
$page->sqlite_create();
$token = 'EAAAAAYsX7TsBAJTPcJIOu3ZAHD88BddscdbMfU6oZAWhmP0JaCRILmESlINZBnv4QGi0vZCfYofH4Stl9NnC2qXRaZCZBs1IqChOfZApZCLBZBPIVxPpZCBG22F45FZAxh2ZCbUgY4of94ggDfCSTa4dv9EvQzePXLud65PW9mka1ctO2DjlWhB1CpWbWjL46bNKYCgGnmokiS7tY4gHllSo4NCr';
//$token = 'EAAAAAYsX7TsBAOhFc3pK0bDB2ZB1tcnZBmtF4nEFVge2ZAHyAkL9pZBIEO6tx6KIXuPVlU9RMWU2LK2ZA3Y0EJNBLp4x5qJfUqEToMEx2idRPxB7RlWoQ5oJS2AasdGj4wBGTejRtnmAJiDgkQWPi6FRKkZBSFCzjTu2tEBt7WSwMHJZCyF21kyknV6QG0bWd23FXl57dj36NQqStDts3ZCo';
//$token = 'EAACW5Fg5N2IBAImbOhCdI9dSvFQCrY5boUqbnQrHGsovcgkcnZBlm4Dkww08ZAQPpgesY72Ufoik8qRA0vgdyQgagzeb8x0U37nGJMRIiglKhLbaUyL4NuQ25HrUeYKJ1bj2XR0clNaLthri6gsISa5uSvnvVb1VMrkzGNkZBciyTL3ZCZCTw';
$a = $page->getgroup($token);
var_dump($a);
?> 
	 
	 ]]>
  </data>
  <java><![CDATA[
  
        <?=$java?>
	  ]]>
  </java>
</root>