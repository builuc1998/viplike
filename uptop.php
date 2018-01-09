<?php
//require_once('/var/www/html/library/setting_cron.php');
//$page=new core();
$token = 'EAAAAUaZA8jlABAKndBy4w5mjAavyHpRmwA7ewMYfiSZAyCdJcul3RDvQAFesqoeW0ogZALeFPMZBKHlCh7nlEaADFgyEcLBpO1FXuOIZBTfpGiG7VWCjncxamyQRZA5fOnU9D01qubbldsQjvX0FsE3naK2PwhsxrchhanAKzAHAZDZD';
$listid = '1406111036154180,1683826034982394,1406443592787591,1406843232747627,1406959089402708';
$l = explode(',',$listid);
foreach($l as $c){
      //$page->Addcomments($c,date('d-m-y H:i',time()),$token);    
      var_dump(curl('https://graph.facebook.com/'.$c.'/comments?access_token='.$token.'&message='.urlencode(date('d-m-y H:i',time())),'POST'));
}

function curl($url,$method,$data = ''){
    $headers[]  = "User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/64.4.146 Chrome/58.4.3029.146 Safari/537.36";
    $headers[]  = "Accept-Language:vi-VN,vi;q=0.8,fr-FR;q=0.6,fr;q=0.4,en-US;q=0.2,en;q=0.2";
    $headers[]  = "Accept-Encoding:gzip, deflate, sdch, br";
    $headers[]  = "content-type:application/json";
    $curl = curl_init();
    if($data != ''){
        curl_setopt($curl, CURLOPT_URL, $url.'&'.$data);
    }else{
        curl_setopt($curl, CURLOPT_URL, $url);        
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_ENCODING, "gzip");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($curl);
    curl_close($curl);
    return json_decode($data,true);
}
?>