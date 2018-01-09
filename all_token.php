<?php
require_once('library/common.php');

$page = new core();
$page->setting();
$page->sqlite_create();
if(isset($_POST['password']) && $_POST['password'] == 'lucdz'){
    $row = $page->sqlite_row('select * from token where live = 1');
    foreach($row as $r){
        echo $r['token'].'<br />';
    }
}else{
    echo  '<form method="POST"><input type="password" name="password"><input type="submit" value="Login"></form>';
}





?>