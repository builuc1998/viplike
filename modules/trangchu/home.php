<?php
$page = new core();
if(isset($_SESSION['info'])){
    $page->create_content('modules/trangchu/home_login.html');    
}else{
    $count_token = $this->sqlite_single_row('select COUNT(*) as C from token');
    $botlike = $this->sqlite_single_row('select COUNT(*) as C from botlike where active = 1');
    $viplike = $this->sqlite_single_row('select COUNT(*) as C from viplike where active = 1');
    $account = $this->sqlite_single_row('select COUNT(*) as C from account where active = 1');
    $page->rv('$count_token',$count_token['C']);
    $page->rv('$botlike',$botlike['C']);
    $page->rv('$account',$account['C']);
    $page->rv('$viplike',$viplike['C']);
    $page->create_content('modules/trangchu/home.html');
}
$row = $this->sqlite_row('select * from menu_auto where xuatban = 1');
foreach($row as $r){
    if($r['me'] == 1){
        if($r['trangthai'] == 1){
            $trangthai = '<button type="button" class="btn btn-block btn-warning">Hoạt động</button>';
            $link = '<a href="'.$r['link'].'" class="btn btn-block btn-success">Sử Dụng</a>';
        }else{
            $trangthai = '<button type="button" class="btn btn-block btn-warning">Bảo Trì</button>';
            $link = '<a href="javascript:void(0)" disabled class="btn btn-block btn-success">Sử Dụng</a>';
        }
        $content .= '
        <div class="col-md-4 table-menu">
            <div class="panel panel-primary">
    			<div class="panel-heading">
    				<center style="font-size: 20px;">'.$r['ten'].'</center>
    			</div>
    			<div class="panel-body">
    				'.$trangthai.$link.'
    			</div>
    		</div>
        </div>';    
    }
    if($r['me'] == 2){
        if($r['trangthai'] == 1){
            $trangthai = '<button type="button" class="btn btn-block btn-warning">Hoạt động</button>';
            $link = '<a href="'.$r['link'].'" class="btn btn-block btn-success">Sử Dụng</a>';
        }else{
            $trangthai = '<button type="button" class="btn btn-block btn-warning">Bảo Trì</button>';
            $link = '<a href="javascript:void(0)" disabled class="btn btn-block btn-success">Sử Dụng</a>';
        }
        $content2 .= '
        <div class="col-md-4 table-menu">
            <div class="panel panel-primary">
    			<div class="panel-heading">
    				<center style="font-size: 20px;">'.$r['ten'].'</center>
    			</div>
    			<div class="panel-body">
    				'.$trangthai.$link.'
    			</div>
    		</div>
        </div>';    
    }
    /*if($r['me'] == 3){
        if($r['trangthai'] == 1){
            $trangthai = '<button type="button" class="btn btn-block btn-warning">Hoạt động</button>';
            $link = '<a href="index.php?f='.$r['link'].'" class="btn btn-block btn-success">Sử Dụng</a>';
        }else{
            $trangthai = '<button type="button" class="btn btn-block btn-warning">Bảo Trì</button>';
            $link = '<a href="javascript:void(0)" disabled class="btn btn-block btn-success">Sử Dụng</a>';
        }
        $content3 .= '
        <div class="col-md-4 table-menu">
            <div class="panel panel-primary">
    			<div class="panel-heading">
    				<center style="font-size: 20px;">'.$r['ten'].'</center>
    			</div>
    			<div class="panel-body">
    				'.$trangthai.$link.'
    			</div>
    		</div>
        </div>';    
    }*/
}
//$page->rv('$content',$content);
$page->rv('$content2',$content2);
$page->rv('$content3',$content3);
$page->create_template();
return $page->content;
?>