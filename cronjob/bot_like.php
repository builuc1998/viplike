<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
date_default_timezone_set('asia/ho_chi_minh');
include('/var/www/html/library/setting_cron.php');
$page = new core();
$page->setting();
$page->sqlite_create();
$row = $page->sqlite_row('select * from botlike where active = 1 order by RANDOM() limit 5');
if(sizeof($row) > 0){
    foreach($row as $r){
        $str = file_get_contents('/var/www/html/cronjob/likes/'.$r['uid']);
        $str = explode(PHP_EOL,$str);
        $url = 'https://graph.facebook.com/me/home?fields=id,story&limit=5&access_token='.$r['access_token'];
        $id = file_get_contents_curl($url);
        var_dump($id);
        foreach($id['data'] as $data){
            if($r['type'] == 'random' || $r['type'] == 'RANDOM'){
                $a=array("HAHA","WOW","SAD","LOVE","LIKE","ANGRY");
                $type2=$a[array_rand($a,1)];
            }else{
                $type2 = $r['type'];
            }
            $check_id = in_array($data['id'],$str);
            if($check_id != true)
            {   
                if(strpos($data['story'],"updated") != false && strpos($data['story'],"updated his status") == false){
                    $idexp = explode('_',$data['id']);
                    $data_id = $idexp[1];
                }else{
                    $data_id = $data['id'];
                }
                echo 'https://graph.facebook.com/'.$data_id.'/reactions?type='.$type2.'&access_token='.$r['access_token'];
                $cu = curl('https://graph.facebook.com/'.$data_id.'/reactions?type='.$type2.'&access_token='.$r['access_token'],'POST');
                if($cu['success'] == true){
                    $fp = fopen('/var/www/html/cronjob/likes/'.$r['uid'], 'a+');
                	fwrite($fp,$data['id'].PHP_EOL);
                	fclose($fp);
                }
            }
        }
    }
}

?>