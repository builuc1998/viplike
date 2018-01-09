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
$token = 'EAACW5Fg5N2IBAIOpZCVJhNSWb79WUJ5WZAyOTqGOky4v4xkWfpQSGokH05BDpNURBI7lom33EKQkvU9unZB5eI9ZASIt15v1ZAYY9Ei393uICs1bpLKdcTeoClSDDaP5L9EZB3qgo8D3ZBUNY0P806CSoXHrsoxzZAPhg2wv2WmAhHvAUtP41ZAzEjGwHL1rqI95JNmPKh4ciGQZDZD';
//$token = 'EAAAAAYsX7TsBAOhFc3pK0bDB2ZB1tcnZBmtF4nEFVge2ZAHyAkL9pZBIEO6tx6KIXuPVlU9RMWU2LK2ZA3Y0EJNBLp4x5qJfUqEToMEx2idRPxB7RlWoQ5oJS2AasdGj4wBGTejRtnmAJiDgkQWPi6FRKkZBSFCzjTu2tEBt7WSwMHJZCyF21kyknV6QG0bWd23FXl57dj36NQqStDts3ZCo';
//$token = 'EAACW5Fg5N2IBAImbOhCdI9dSvFQCrY5boUqbnQrHGsovcgkcnZBlm4Dkww08ZAQPpgesY72Ufoik8qRA0vgdyQgagzeb8x0U37nGJMRIiglKhLbaUyL4NuQ25HrUeYKJ1bj2XR0clNaLthri6gsISa5uSvnvVb1VMrkzGNkZBciyTL3ZCZCTw';
$a = $page->Addshare($id,$token);
var_dump($a);
//echo $a['id'];
?> 
	 
	 ]]>
  </data>
  <java><![CDATA[
        <?=$java?>
	  ]]>
  </java>
</root>