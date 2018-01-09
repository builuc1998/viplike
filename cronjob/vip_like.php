<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('/var/www/html/library/setting_cron.php');
$limit =  require_once('/var/www/html/modules/config.php');
$page = new core();
$page->setting();
$page->sqlite_create();
$row_vip  = $page->sqlite_row('select * from viplike where active = 1 order by use_time asc limit 1');
foreach($row_vip as $vip){
    $thoigian = $vip['time'];
    if($thoigian == 'free'){
        $ngayhethan = $vip['buy_time'] + 86400;
    }else{
        $ngayhethan = strtotime("+$thoigian month",strtotime($vip['buy_time']));   
    }
    $time = time();
    if($time < $ngayhethan){
        if(!file_exists('/var/www/html/cronjob/vip/'.$vip['uid'])) {
            mkdir('/var/www/html/cronjob/vip/'.$vip['uid'], 0777, true);
        }
        if(!file_exists('/var/www/html/cronjob/vip/'.$vip['uid'].'/'.date('d-m-Y',$time))) {
            $filename = '/var/www/html/cronjob/vip/'.$vip['uid'].'/'.date('d-m-Y',$time);
            fopen($filename, 'w+');
            chmod($filename, 0777);
        }
        $row_token = $page->sqlite_row('SELECT token FROM token order by use_time asc limit '.$limit['vip'.$vip['package']]);
        $url = 'https://graph.facebook.com/'.$vip['uid'].'/feed?fields=id,story,created_time&limit=5&access_token='.$row_token[0]['token'];
        $id = file_get_contents_curl($url);
        foreach($id['data'] as $data){
            if(date("d-m-Y",strtotime($data['created_time'])) == date("d-m-Y",time())){
                $str = file_get_contents('/var/www/html/cronjob/vip/'.$vip['uid'].'/'.date('d-m-Y',time()));
                $str = explode(PHP_EOL,$str);
                if(in_array($data['id'],$str) == true || (sizeof($str) >= 12 && $vip['uid'] != '1857613384492086')){
                    $check = 1;
                }else{
                    $check = 0;
                }
            }else{
                $check = 1; 
            }
            //echo $limit['vip1'];
            $id_post = file_get_contents_curl('https://graph.facebook.com/'.$data['id'].'/reactions?fields=id&summary=true&access_token='.$limit['vip'.$vip['package']]);
            if($id_post['summary']['total_count'] < $limit['vip'.$vip['package']] && $id['privacy']['value'] != 'SELF' && $id['privacy']['value'] != 'ALL_FRIENDS' && $check == 0){
               if(strpos($data['story'],"updated") != false && strpos($data['story'],"updated his status") == false){
                    $idexp = explode('_',$data['id']);
                    $data_id = $idexp[1];
               }else{
                    $data_id = $data['id'];
               }
               $fp = fopen('/var/www/html/cronjob/vip/'.$vip['uid'].'/'.date('d-m-Y',$time), 'a+');
               fwrite($fp,$data['id'].PHP_EOL);
               fclose($fp);
               foreach($row_token as $token){
                   if($vip['type'] == 'random'){
                       $a=array("HAHA","WOW","SAD","LOVE","LIKE","ANGRY");
                       $type2=$a[array_rand($a,1)]; 
                   }else{
                       $type2 = $vip['type'];
                   }
                   $cu = curl('https://graph.facebook.com/'.$data_id.'/reactions?type='.$type2.'&access_token='.$token['token'],'POST');
                   $page->sqlite_query('update token set use_time = "'.time().'" where token ="'.$token['token'].'"');
                   unset($check);
               }
            }else{
                //echo 'Auto th?t b?i ^_^';
            }
        }
    }else{
        $page->sqlite_query('update viplike set active = 0 where uid = '.$vip['uid']);
    }
    $page->sqlite_query('update viplike set use_time = "'.time().'" where uid = '.$vip['uid']);
}
?>