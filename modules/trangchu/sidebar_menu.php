<?php
session_start();
$page = new core();
$page->setting();
$page->sqlite_create();
$page->create_content('modules/trangchu/sildebar_menu.html');
$menu = $this->sqlite_row('select * from menu_auto where xuatban = 1 and trangthai = 1 order by id desc');
if(isset($_SESSION['info'])){
    $name = $_SESSION['info']['fullname'];
    $user = '<div class="pull-left image">
                 <img src="https://cdn-images-1.medium.com/max/1600/0*MzEDN-Y0wRzYJ8Wo.png" class="img-circle" alt="User Image">
             </div>
             <div class="pull-left info">
              <p>'.$name.'</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>';
}else{
    $user = '<div class="pull-left image">
                 <img src="https://cdn-images-1.medium.com/max/1600/0*MzEDN-Y0wRzYJ8Wo.png" class="img-circle" alt="User Image">
             </div>
             <div class="pull-left info">
              <p>Khách</p>
              <a href="#"><i class="fa fa-circle text-danger"></i> Offline</a>
            </div>';   
}
$con = $me = [];
foreach($menu as $m){
    if($m['me'] == -1){
        $me[$m['id']] = $m;
    }else if($m['me'] == 0){
        $me[$m['id']] = $m;
    } else {
        $con[$m['me']] = $m;
    }
}
$str = '';
if(isset($_SESSION['info'])){
    /*$str .= '<li>
          <a href="javascript:$(\'#tmtopup\').modal(\'show\');">
            <i class="fa fa-usd"></i> <span> Recharge</span>
          </a>
        </li>';*/
}
foreach($me as $m){
    if(isset($con[$m['id']])){
        $str .= '<li class="treeview">
          <a href="#">
            <i class="fa '.$m['icon'].'"></i> <span>'.$m['ten'].'</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">';
          foreach($menu as $m2){
                if($m2['me'] == $m['id']){
                $str .= '<li class=""><a href="'.$m2['link'].'"><i class="fa '.$m2['icon'].'"></i> '.$m2['ten'].'</a></li>';
            }
          }

        $str .= ' </ul>
            </li>';
    }else{
        $str .= '<li>
          <a href="'.$m['link'].'">
            <i class="fa '.$m['icon'].'"></i> <span>'.$m['ten'].'</span>
            <!--<span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>-->
          </a>
        </li>';
    }
}
$page->rv('$user',$user);
$page->rv('$str',$str);
$page->create_template();
return $page->content;
?>