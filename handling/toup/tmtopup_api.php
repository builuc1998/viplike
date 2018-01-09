<?php
require_once('../../library/common.php');
$page=new core();
$page->setting();
$page->sqlite_create();
session_start();

# ------------------------------------- Config Begin ------------------------------------- #
// ------------------------------------------------------------------------------------------------
/* MySQL Config | Begin */
// Hostname ของ MySQL Server
//$_CONFIG['mysql']['dbhost'] = 'localhost';

// Username ที่ใช้เชื่อมต่อ MySQL Server
//$_CONFIG['mysql']['dbuser'] = 'root';

// Password ที่ใช้เชื่อมต่อ MySQL Server
//$_CONFIG['mysql']['dbpw'] = '123456';

// ชื่อฐานข้อมูลที่เราจะเติม Point ให้
//$_CONFIG['mysql']['dbname'] = 'gta';

// ชื่อตารางที่เราจะเติม Point ให้ ตัวอย่าง : member
//$_CONFIG['mysql']['tbname'] = 'member';

// ชื่อ field ที่ใช้อ้าง Username
$_CONFIG['mysql']['field_username'] = 'username';

// ชื่อ field ที่ใช้ในการเก็บ Point จากการเติมเงิน
$_CONFIG['TMN']['point_field_name'] = 'monney';
/* MySQL Config | End */
// ------------------------------------------------------------------------------------------------


// ------------------------------------------------------------------------------------------------
/* จำนวน Point ที่จะได้รับเมื่อเติมเงินในราคาต่างๆ | Begin */
$_CONFIG['TMN'][50]['point'] = 120;					// Point ที่ได้รับเมื่อเติมเงินราคา 50 บาท
$_CONFIG['TMN'][90]['point'] = 200;					// Point ที่ได้รับเมื่อเติมเงินราคา 90 บาท
$_CONFIG['TMN'][150]['point'] = 350;				// Point ที่ได้รับเมื่อเติมเงินราคา 150 บาท
$_CONFIG['TMN'][300]['point'] = 800;				// Point ที่ได้รับเมื่อเติมเงินราคา 300 บาท
$_CONFIG['TMN'][500]['point'] = 1200;				// Point ที่ได้รับเมื่อเติมเงินราคา 500 บาท
$_CONFIG['TMN'][1000]['point'] = 2000;			// Point ที่ได้รับเมื่อเติมเงินราคา 1,000 บาท
/* จำนวน Point ที่จะได้รับเมื่อเติมเงินในราคาต่างๆ | End */
// ------------------------------------------------------------------------------------------------


// กำหนด API Passkey
define('API_PASSKEY', 'mynarok');

# -------------------------------------- Config End -------------------------------------- #


require_once('AES.php');


// ------------------------------------------------------------------------------------------------
/* เชื่อมต่อฐานข้อมูล | Begin */
//mysql_connect($_CONFIG['mysql']['dbhost'],$_CONFIG['mysql']['dbuser'],$_CONFIG['mysql']['dbpw']) or die('ERROR|DB_CONN_ERROR|' . mysql_error());
//mysql_select_db($_CONFIG['mysql']['dbname']) or die('ERROR|DB_SEL_ERROR|' . mysql_error());
/* เชื่อมต่อฐานข้อมูล | End */
// ------------------------------------------------------------------------------------------------


if($_SERVER['REMOTE_ADDR'] == '203.146.127.115' && !isset($_GET['request']))
{
	$aes = new Crypt_AES();
	$aes->setKey(API_PASSKEY);
	$_GET['request'] = base64_decode(strtr($_GET['request'], '-_,', '+/='));
	$_GET['request'] = $aes->decrypt($_GET['request']);
	if($_GET['request'] == false)
	{
		parse_str($_GET['request'],$request);
		$request['Ref1'] = base64_decode($request['Ref1']);

		/* Database connection | Begin */
		$result = $page->sqlite_single_row('SELECT `id` FROM `account` WHERE `username` ="'. SQLite3::escapeString($_SESSION['info']['username']) . '" LIMIT 1') or die("Can't connect db");
		if(sizeof($result) > 0)
		{
		  if($request['cardcard_amount'] != 0){
		      $success = 1;
		  }else{
		      $success = 0;
		  }
		  $page->sqlite_query('insert into charge_history (username,point,info) VALUES ("'.$_SESSION['info']['username'].'","'.$request['cardcard_amount'].'","'.SQLite3::escapeString($request).'")');
          if($page->sqlite_query('update account set monney = monney + '.$_CONFIG['TMN'][$request['cardcard_amount']]['point'].' where id = '.$result['id']) == true){
            	echo 'SUCCEED|UID=' . $result[$_CONFIG['mysql']['field_username']];
          }else{
            	echo 'ERROR|MYSQL_UDT_ERROR|';
          }
			/*if(mysql_query('UPDATE `'. $_CONFIG['mysql']['tbname'] .'` SET `' . $_CONFIG['TMN']['point_field_name'] . '`=`' . $_CONFIG['TMN']['point_field_name'] . '`+' . $_CONFIG['TMN'][$request['cardcard_amount']]['point'] . ' WHERE `'. $_CONFIG['mysql']['field_username'] .'`=' . $result[$_CONFIG['mysql']['field_username']]) == false)
			{
				echo 'ERROR|MYSQL_UDT_ERROR|';
			}
			else
			{
				echo 'SUCCEED|UID=' . $result[$_CONFIG['mysql']['field_username']];
			}*/
		}
		else
		{
			echo 'ERROR|INCORRECT_USERNAME';
		}
		/* Database connection | End */

	}
	else
	{
		echo 'ERROR|INVALID_PASSKEY';
	}
}
else
{
	echo 'ERROR|ACCESS_DENIED';
}
?>