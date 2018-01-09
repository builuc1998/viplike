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
$limit = (int)$_POST['limit'];
$type = $_POST['type'];
if($limit < 101){
    $check_token = check_token_live($_SESSION['info']['access_token']);
    if($check_token['id']){
        $uid = $check_token['id'];
        $check = $page->sqlite_single_row('select * from block_time where type = "reaction" and (username = "'.$_SESSION['info']['username'].'" or ip ="'.$_SERVER['REMOTE_ADDR'].'" or uid = "'.$uid.'")');
        if(sizeof($check) > 0){
            if((time() > ($check['time'] + 900)) == false){//block like 15m
                $tong = ($check['time'] + 900) - time();
                $block = 1;
                $error = 'You can not use right now. come back after '.convert_time($tong);
            }else{
                $block = 0;
                $page->sqlite_query('delete from block_time where type = "reaction" and (username ="'.$_SESSION['info']['username'].'" or ip = "'.$_SERVER['REMOTE_ADDR'].'" or uid = "'.$uid.'")');
            }
        }else{
            $block = 0;
        }
        if($block != 1){
            $row = $page->sqlite_row('select * from token where live = 1 order by RANDOM() limit '.$limit);
            foreach($row as $r){
                if($type == 'random'){
                    $a=array("HAHA","WOW","SAD","LOVE","LIKE","ANGRY");
                    $type2=$a[array_rand($a,1)];        
                }else{
                    $type2 = $type;
                }
                $a2 = $page->reactions($id,$type2,$r['token']);
                curl($a2,"POST");
            }
            $page->sqlite_query('insert into block_time (time,type,username,ip,uid) VALUES ("'.time().'","reaction","'.$_SESSION['info']['username'].'","'.$_SERVER['REMOTE_ADDR'].'","'.$uid.'")');
            $success = 'Auto kết thúc';
        }
    }else{
        $error ='Bạn cần thêm Token để có thể sử dụng chức năng này';
        $java = '$(\'#input_token\').html("<label>Access Token:</label><input type=\'text\' onchange=\'access_token('.$_SESSION['info']['id'].')\' placeholder=\'Paste Access Token : EAAAAUaZA8jlABAFkkpnWcP8ZAHXNd8Dd1W2tZAxp5ljHE2EUspZBwSHqy0urrruGKIiknNoOF9af34WK\' class=\'form-control add_token\' id=\'access_token\'>");';
    }
}else{
    $error = 'Đéo Bug được đâu';
}
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