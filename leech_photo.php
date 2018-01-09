<?php
$token =  'EAAAAUaZA8jlABAJEAjxodscGrxpzYwdbhyr1wBgHt5q9pBfqW8UyNPuE4kCOxd0YA9uqj3dtO9iDkwmcQgBOzTV5kibZBafXPnKdLdVJZAEo5nnRdekWev7QGkw8nxdgAZC4ylcPK7fwFn9X7Bw61ctWvIcXCjcZD';
$token_page = 'EAAAAUaZA8jlABAEWSkcP1gQR0Yjir5ZAnR0hnMB9q2CjZCNymaNzmxddT9t7TEZBrrEVttazABYGZAo1PZB0QBARj27tnhr8mGaVQf0OmDD6G7THfUtr6prbZADxZBvuIdrVlZC3fsXgGFfDqJf1sZC2qCWGewbnUv8tNTzPb32F49zwZDZD';
$link = 'https://graph.facebook.com/v2.10/1173636692750000/feed?fields=full_picture,message,status_type&limit=2&access_token='.$token;
$a = file_get_contents_curl($link);
foreach($a['data'] as $r){
    if($r['status_type'] == 'added_photos'){
        $id = $r['id'];
        $message = $r['message'];
        $full_picture = urlencode($r['full_picture']);
        if(!file_exists('/var/www/html/leech/'.$id)){
            $url = 'https://graph.facebook.com/v2.10/me/photos?url='.$full_picture.'&message='.urlencode($r['message']).'&access_token='.$token_page;
            var_dump(curl($url,'POST'));
            $fp = fopen('/var/www/html/leech/'.$id, 'a+');
    		fclose($fp);
        }else{
            echo 'có file r?i';
        }

    }
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
function file_get_contents_curl($url) 
{
    $user_agents = array(
		"Mozilla/5.0 (Linux; Android 5.0.2; Andromax C46B2G Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/60.0.0.16.76;]",
		"[FBAN/FB4A;FBAV/35.0.0.48.273;FBDM/{density=1.33125,width=800,height=1205};FBLC/en_US;FBCR/;FBPN/com.facebook.katana;FBDV/Nexus 7;FBSV/4.1.1;FBBK/0;]",
		"Mozilla/5.0 (Linux; Android 5.1.1; SM-N9208 Build/LMY47X) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.81 Mobile Safari/537.36",
		"Mozilla/5.0 (Linux; U; Android 5.0; en-US; ASUS_Z008 Build/LRX21V) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.8.0.718 U3/0.8.0 Mobile Safari/534.30",
		"Mozilla/5.0 (Linux; U; Android 5.1; en-US; E5563 Build/29.1.B.0.101) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.10.0.796 U3/0.8.0 Mobile Safari/534.30",
		"Mozilla/5.0 (Linux; U; Android 4.4.2; en-us; Celkon A406 Build/MocorDroid2.3.5) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"
	);
	$useragent = $user_agents[array_rand($user_agents)];
    if ( function_exists('curl_init') ) 
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        if ($data === FALSE) {
            $data =  "cURL Error: " . curl_error($ch);
        }
        curl_close($ch);
    } else {
        $data = $url;
    }
    return json_decode($data,true);
}
?>