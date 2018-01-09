<?php
date_default_timezone_set('asia/ho_chi_minh');
class core
{
function get_relative()
{
	$self=$_SERVER['PHP_SELF'];
	$sogach=substr_count($self, '/')-1;
	if($_SERVER['SERVER_NAME']=='localhost')
	{
		$sogach=$sogach-1;
	}
	$this->relative=@str_repeat('../',$sogach);
	return $this->relative;
}
function setting()
{
	$this->get_relative();
}
function bootstrap(){
    echo '  <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="/templates/asset/bootstrap/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="/templates/asset/awesome/css/font-awesome.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="/templates/asset/toastr/toastr.min.css">
      <link rel="stylesheet" href="/templates/asset/adminlite/AdminLTE.min.css">
      <link rel="stylesheet" href="/templates/asset/adminlite/style.css">
      <link rel="stylesheet" href="/templates/asset/adminlite/_all-skins.min.css">
      <link rel="shortcut icon" href="templates/images/icon.ico" type="image/x-icon" />
      <link rel="icon" href="templates/images/icon.ico" type="image/x-icon" />
      <!-- Google Font -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <script src="/java/jquery-1.11.0.min.js"></script>
      <script src="/templates/asset/bootstrap/js/bootstrap.min.js"></script>
      <script src="/templates/asset/adminlite/adminlte.min.js"></script>
      <script src="/templates/asset/toastr/toastr.min.js"></script>
      <script src="/java/java.js"></script>
      <script src="/java/index.js"></script>
      <script src="/java/getid.js"></script>';
}
function sqlite_create()
{
	if(!isset($this->dbhandle))
	{
		$db='data/liker.db';
        if(!is_file($db))$db='../data/liker.db';
		if(!is_file($db))$db='../../data/liker.db';
		if(!is_file($db))$db='../../../data/liker.db';
		$this->dbhandle = new SQLite3($db);
		$this->dbhandle->busyTimeout(5000);
	}
}
function sqlite_query($sql)
{
	//$this->result=$this->dbhandle->query($sql);
    if($this->dbhandle->query($sql))
	{
	   //$this->result=true;
	   return true;
	}else
	{
	   //$this->result = false;	
	   return false;
	}
}
function sqlite_row($sql)

{

	unset($this->sqlite_row);

	$result = $this->dbhandle->query($sql);

	while($res = $result->fetchArray(SQLITE3_ASSOC)){



		$this->sqlite_row[]=$res;

	}

	return $this->sqlite_row;

}



function sqlite_single_row($sql)

{

 	unset($this->sqlite_single_row);

	$result = $this->dbhandle->query($sql);



	$this->sqlite_single_row=$this->dbhandle->querySingle($sql, true);

	return $this->sqlite_single_row;

}
function mem_get($key)
{
	if(!$this->memcache)
	{
		$this->memcache = new Memcache;
		$host='localhost';
		if(get_node()!=1)$host='10.0.0.1';
		@$this->memcache->connect($host, 11211) or die ("");
	}
	return $this->memcache->get($key);
}
function mem_set($key,$var,$flag=false,$expire=0)
{
	if(!$this->memcache)
	{
		$this->memcache = new Memcache;
		$host='localhost';
		if(get_node()!=1)$host='10.0.0.1';
		@$this->memcache->connect($host, 11211) or die ("");
	}
	$this->memcache->set($key,$var,$flag,$expire);
}
function mem_del($key)
{
	if(!$this->memcache)
	{
		$this->memcache = new Memcache;
		$host='localhost';
		if(get_node()!=1)$host='10.0.0.1';
		@$this->memcache->connect($host, 11211) or die ("");
	}
	$this->memcache->delete($key);
}
function mem_flush()
{
	if(!$this->memcache)
	{
		$this->memcache = new Memcache;
		$host='localhost';
		if(get_node()!=1)$host='10.0.0.1';
		@$this->memcache->connect($host, 11211) or die ("");
	}
	$this->memcache->flush();
}
function check_domain($domain)
{
 	$domain=str_replace('_','',$domain);
	if (preg_match ("#^(([a-z0-9][-a-z0-9]*?[a-z0-9])\.)+[a-z]{2,7}$#", $domain)) {
	return true;
	} else {
    return false;
	}
}
function create_main_html()
{
	if($_SESSION['mobilev']!=1)
	{
		include 'library/Mobile-Detect-2.8.11/Mobile_Detect.php';
		$detect = new Mobile_Detect();
		// Check for any mobile device.
		if ($detect->isMobile() && !$detect->isTablet())
		$_SESSION['mobilev']=1;
	}
    if($_GET['print'] == 1){
        $this->create_content('templates/print.html');
    }else{
        $this->create_content('templates/index.html');
    }
}
function get_object_from_xml_file($file,$key,$relative=NULL)
{
	require_once('library/xml_array.php');
	$this->xml_object = readDatabase($relative.$file,$key);
}
function utf8_strlen($s) {
    return strlen(utf8_decode($s));
}
function get_cutted_string($str,$len,$more='...'){
	# utf8 substr
	# www.yeap.lv
	if($this->utf8_strlen($str)>$len)
	{
		$addmore=$more;
	}
	$from=0;
return @preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
			   '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
			   '$1',$str).$addmore;
}
function create_content($template)
{
	$this->content = @file_get_contents($template) or die ('Khong tim thay file giao dien '.$template);
}
function rv($key,$value)
{
	$this->replace_array[]=array($key,$value);
}
function replace_all($row,$strip=1)
{
	if(sizeof($row)>0)
	{
		foreach($row as $name=>$value)
		{
			if($strip==1)$value=stripslashes($value);
			$this->rv('$'.$name,$value);
		}
	}
}
function replace_element($key,$value)
{
	$this->content=str_replace($key,$value ,$this->content);
}
function rl($key,$key_array,$row_array,$comment_type=null)
{
	if(count($row_array)>0)
	{
		$loop_content='/*'.$this->content.'*/';
		foreach($key_array as $ka)
		{
			$i_ndot++;
			eval($ka.'=$ka;');
			$command.=$ka.'=$ra['.($i_ndot-1).'];';
		}
		if($this->replace_out_loop!=TRUE or !isset($this->replace_out_loop))
		{
			if(count($this->replace_array)>0)
			{
				foreach($this->replace_array as $ra)
				{
					@eval($ra[0].'=$ra[1];');
				}
			}
		}
		$begin='*/
		foreach($row_array as $ra)
		{
			'.$command.'
			$piece.=<<<CHEN
';
			$end='
CHEN;
		}
	/*
	';
		${begin_loop.$key}=$begin;
		${end_loop.$key}=$end;
		eval('$content=<<<CHEN
'.$loop_content.'
CHEN;
	');
		eval($content);
		$key='loop'.$key;
		$this->replace_loop_array[]=array($key,$piece);
	}
}
function get_part_loop()
{
	if(count($this->replace_array)>0)
	{
		foreach($this->replace_array as $ra)
		{
			@eval($ra[0].'=$ra[1];');
		}
	}
	if(count($this->replace_loop_array)>0)
	{
		$loop_content='$nd=<<<CHEN
'.$this->content.'
CHEN;
';
	$begin_loop='

CHEN;
/*
';
	$end_loop='
*/
$this->duoi=<<<CHEN
	';
		eval($loop_content);
		$nd='$this->dau=<<<CHEN
'.$nd.'
CHEN;
';
	eval($nd);
	}
}
function create_template()
{
	if(count($this->replace_loop_array)!=1)
	{
		if(count($this->replace_array)>0)
		{
			foreach($this->replace_array as $ra)
			{
				@eval($ra[0].'=$ra[1];');
			}
		}
		if(count($this->replace_loop_array)>0)

		{

			foreach($this->replace_loop_array as $rla)

			{

				${begin_.$rla[0]}	=	$rla[1].'<!--';

				${end_.$rla[0]}	=	'-->';



			}

		}



		@eval('$content=<<<CHEN

	'.$this->content.'

CHEN;

		');



		$this->content=@encode_string($content);



	}

	else

	{

		$this->get_part_loop();

		foreach($this->replace_loop_array as $rla)

		{

			$giualap=$rla[1];



		}

		$this->content=@encode_string($this->dau.$giualap.$this->duoi);

	}

}





function show_html()

{

	echo $this->content;

}







function encode_post($data)

{

	return @encode_string((trim(($this->decode_java($data)))));

}

function encode_post_2($data)

{

	return @encode_string(trim($data));

}



function encode_text_area($data)

{

	return @encode_string((trim((strip_tags($this->decode_java($data),'<br></br></ br>')))));

}



public function QueryBuilder(){

    $node='app/src/GraphNode.php';

    if(!is_file($node))$node='../app/src/GraphNode.php';

    if(!is_file($node))$node='../../app/src/GraphNode.php';

    if(!is_file($node))$node='../../../app/src/GraphNode.php';

    /*******/

    $fqb='app/src/FQB.php';

    if(!is_file($fqb))$fqb='../app/src/FQB.php';

    if(!is_file($fqb))$fqb='../../app/src/FQB.php';

    if(!is_file($fqb))$fqb='../../../app/src/FQB.php';

    /******/

    $ed='app/src/GraphEdge.php';

    if(!is_file($ed))$ed='../app/src/GraphEdge.php';

    if(!is_file($ed))$ed='../../app/src/GraphEdge.php';

    if(!is_file($ed))$ed='../../../app/src/GraphEdge.php';

    include_once $node;

    include_once $fqb;

    include_once $ed;

}



function encode_text($data)

{

	return (trim((strip_tags($this->decode_java($data)))));

}



function encode_editor($data)

{

	$allow_tag='<strong><em><b><p><a><br></br></ br><div><style><span><img><table><tbody><th><tr><td><center><h1><h2><h3><h4><h5><h6><li><ul><font><pre><i><hr><object><embed><param><flash><iframe><script><mce:script><xmp><blockquote>';

	//echo '<xmp>'.$data.'</xmp>';

	return (trim(($this->decode_java(strip_tags($data,$allow_tag)))));

}





function encode_sqlite($data)

{

	return sqlite_escape_string($data);

}



function decode_java($data)

{

	return $data;

}



function decode($data)

{

	return stripslashes($data);

}





function get_post_data()

{

	if($_POST['text_array']!='')

	{

		$text_array=$this->encode_post($_POST['text_array']);

		$pieces = explode(" ", $text_array);

		foreach($pieces as $p)

		{

			$text_result[$p]=$this->encode_post($_POST[$p]);

		}

		$result['text']=$text_result;

	}

	if($_POST['select_one_array']!='')

	{

		$select_one_array=$this->encode_post($_POST['select_one_array']);

		$pieces = explode(" ", $select_one_array);

		foreach($pieces as $p)

		{

			$select_one_result[$p]=$this->encode_post($_POST[$p]);

		}

		$result['select_one']=$select_one_result;

	}



	if($_POST['logic_array']!='')

	{

		$logic_array=$this->encode_post($_POST['logic_array']);

		$pieces = explode(" ", $logic_array);

		foreach($pieces as $p)

		{

			$logic_result[$p]=$_POST[$p];

		}

		$result['logic']=$logic_result;

	}



	if($_POST['textarea_array']!='')

	{

		$textarea_array=$this->encode_post($_POST['textarea_array']);

		$pieces = explode(" ", $textarea_array);

		foreach($pieces as $p)

		{

			$textarea_result[$p]=$this->encode_post(nl2br($_POST[$p]));

		}

		$result['textarea']=$textarea_result;

	}

	if($_POST['frame_array']!='')

	{

		$frame_array=$this->encode_post($_POST['frame_array']);

		$pieces = explode(" ", $frame_array);

		foreach($pieces as $p)

		{

			$frame_result[$p]=$this->encode_post($_POST[$p]);

		}

		$result['frame']=$frame_result;

	}





	if($_POST['select_multiple']!='')

	{

		$select_multiple_array=$this->encode_post($_POST['select_multiple']);

		$pieces = explode(" ", $select_multiple_array);



		foreach($pieces as $p)

		{

			$select_multiple_result[$p]=$this->encode_post($_POST[$p]);

		}

		$result['select_multiple']=$select_multiple_result;

	}

	if($_POST['select_multiple_inner']!='')

	{

		$select_multiple_innerHTML_array=$this->encode_post($_POST['select_multiple_inner']);

		$pieces = explode(" ", $select_multiple_innerHTML_array);

		foreach($pieces as $p)

		{

			$select_multiple_innerHTML_result[$p]=$this->encode_post($_POST['select_multiple_inner']);

		}

		$result['select_multiple_inner']=$select_multiple_innerHTML_result;

	}





	return $result;



}





function get_post_data_2()

{

	if($_POST['text_array']!='')

	{

		$text_array=$this->encode_post_2($_POST['text_array']);

		$pieces = explode(" ", $text_array);

		foreach($pieces as $p)

		{

			$text_result[$p]=$this->encode_post_2($_POST[$p]);

			$result_all[$p]=$this->encode_post_2($_POST[$p]);

		}

		$result['text']=$text_result;

	}

	if($_POST['select_one_array']!='')

	{

		$select_one_array=$this->encode_post_2($_POST['select_one_array']);

		$pieces = explode(" ", $select_one_array);

		foreach($pieces as $p)

		{

			$select_one_result[$p]=$this->encode_post_2($_POST[$p]);

			$result_all[$p]=$this->encode_post_2($_POST[$p]);

		}

		$result['select_one']=$select_one_result;

	}



	if($_POST['logic_array']!='')

	{

		$logic_array=$this->encode_post_2($_POST['logic_array']);

		$pieces = explode(" ", $logic_array);

		foreach($pieces as $p)

		{

			$logic_result[$p]=$_POST[$p];

			$result_all[$p]=$this->encode_post_2($_POST[$p]);

		}

		$result['logic']=$logic_result;

	}



	if($_POST['textarea_array']!='')

	{

		$textarea_array=$this->encode_post_2($_POST['textarea_array']);

		$pieces = explode(" ", $textarea_array);

		foreach($pieces as $p)

		{

			$textarea_result[$p]=$this->encode_post_2($_POST[$p]);

			$result_all[$p]=$this->encode_post_2($_POST[$p]);

		}

		$result['textarea']=$textarea_result;

	}

	if($_POST['frame_array']!='')

	{

		$frame_array=$this->encode_post_2($_POST['frame_array']);

		$pieces = explode(" ", $frame_array);

		foreach($pieces as $p)

		{

			$frame_result[$p]=$this->encode_post_2($_POST[$p]);

			$result_all[$p]=$this->encode_post_2($_POST[$p]);

		}

		$result['frame']=$frame_result;

	}





	if($_POST['select_multiple']!='')

	{

		$select_multiple_array=$this->encode_post_2($_POST['select_multiple']);

		$pieces = explode(" ", $select_multiple_array);

		foreach($pieces as $p)

		{

			$select_multiple_result[$p]=$this->encode_post_2($_POST[$p]);

			$result_all[$p]=$this->encode_post_2($_POST[$p]);

		}

		$result['select_multiple']=$select_multiple_result;

	}

	if($_POST['select_multiple_innerHTML']!='')

	{

		$select_multiple_innerHTML_array=$this->encode_post_2($_POST['select_multiple_innerHTML']);

		$pieces = explode(" ", $select_multiple_innerHTML_array);

		foreach($pieces as $p)

		{

			$select_multiple_innerHTML_result[$p]=$this->encode_post_2($_POST[$p.'innerHTML']);

			//$result_all[$p]=$this->encode_post_2($_POST[$p]);

			$result_all[$p]=$this->encode_post_2($_POST[$p.'innerHTML']);

		}

		$result['select_multiple_innerHTML']=$select_multiple_innerHTML_result;

	}

	$this->result_all=$result_all;

	return $result;



}



function a($value)

{

	if($value=='')return '';

	return (int)$value;

}



function check_var($var,$error_string='')

{

	$arr1 = str_split($var);

	if(ord($arr1[0])>=48 and ord($arr1[0])<=57)

	{

		$this->error[]=$error_string;

		return false;

	}

	foreach($arr1 as $a)

	{

		$ok=0;

		if(ord($a)>=65 and ord($a)<=90)$ok=1;

		if(ord($a)>=97 and ord($a)<=122)$ok=1;

		if(ord($a)>=48 and ord($a)<=57)$ok=1;

		if(ord($a)==95)$ok=1;

		if($ok===0)

		{

			$this->error[]=$error_string;

			return false;

		}

	}



}



function check_non_speacial_char($var,$error_string='')

{

	$arr1 = str_split($var);

	foreach($arr1 as $a)

	{

		$ok=0;

		if(ord($a)>=65 and ord($a)<=90)$ok=1;

		if(ord($a)>=97 and ord($a)<=122)$ok=1;

		if(ord($a)>=48 and ord($a)<=57)$ok=1;

		if(ord($a)==95)$ok=1;

		if($ok===0)

		{

			$this->error[]=$error_string;

			return false;

		}

	}



}

function check_is_num($var,$error_string='')

{

	$arr1 = str_split($var);

	foreach($arr1 as $a)

	{

		$ok=0;

		if(ord($a)>=48 and ord($a)<=57)$ok=1;

		if($ok===0)

		{

			$this->error[]=$error_string;

			return false;

		}

	}



}



function check_null($var,$error_string='')

{

	if($var=='')$this->error[]=$error_string;

}



function get_error($error=NULL,$option1='',$option2='')

{

	if(!isset($error))$error=$this->error;

	if(count($error)>0)

	{

		foreach($error as $e)

		{

			$er.=$option1.$e.$option2;

		}

		return $er;

	}



}



function m($module,$option=NULL)

{
	return @include("modules/".$module);

}
function create_admin()
{
	$this->create_content('../templates/admin.html');
}
function get_query_string($exist_array=NULL,$sub_array=NULL,$and_string='&amp;')
{
	if(isset($exist_array))
	{
		$new_array=array_merge($_GET, $exist_array);
		foreach($new_array as $name=>$value)
		{
			$name=$this->clear_file($name);
			$value=$this->clear_file($value);
			$s_string.=$and_string.$name.'='.$value;
		}
	}



	if(isset($sub_array))

	{

		$new_array=array_merge($_GET, $sub_array);

		foreach($sub_array as $name=>$value)

		{

			$name=$this->clear_file($name);

			$value=$this->clear_file($value);

			unset($new_array[$name]);

		}

		foreach($new_array as $name=>$value)

		{

			$name=$this->clear_file($name);

			$value=$this->clear_file($value);

			$s_string.=$and_string.$name.'='.$value;

		}





	}

	if(substr($s_string,0,5)==$and_string)return substr($s_string,5);

	return substr($s_string,1);

}







function rewrite_to_get()

{

	$stringurl=$_GET['stringurl'];

	$stringurl_array=explode('&',$stringurl);

	foreach($stringurl_array as $r)

	{

		$get_array=explode('=',$r);

		$key=$get_array[0];

		$value=$get_array[1];

		$_GET[$key]=$value;

	}

}



function get_rewrite_query_string($exist_array=NULL,$sub_array=NULL,$and_string='&amp;')

{

	foreach($exist_array as $name=>$value)

	{

		$sub_array[$name]=0;

	}

			print_r($my_get);



	if(isset($exist_array))

	{

		$new_array=array_merge($my_get, $exist_array);

		foreach($new_array as $name=>$value)

		{



			$name=$this->clear_file($name);

			$value=$this->clear_file($value);

			$s_string.=$and_string.$name.'='.$value;

		}

	}



	if(isset($sub_array))

	{



		$new_array=array_merge($my_get, $sub_array);

		foreach($sub_array as $name=>$value)

		{

			$name=$this->clear_file($name);

			$value=$this->clear_file($value);

			unset($new_array[$name]);

		}

		foreach($new_array as $name=>$value)

		{

			$name=$this->clear_file($name);

			$value=$this->clear_file($value);

			$s_string.=$and_string.$name.'='.$value;

		}





	}

	if(substr($s_string,0,5)==$and_string)return substr($s_string,5);

	return substr($s_string,1);

}















function encode_edit($edit)

{

	return htmlentities($edit,ENT_QUOTES,'UTF-8');

}





function show_error_note()

{

	$string='

	if(sizeof($java_error_element)>0)

	{

		foreach($java_error_element as $j)

		{

			echo \'hidden_element("\'.$j.\'");\';



		}



	}

	if(sizeof($java_error)>0)

	{

		foreach($java_error as $j)

		{

			echo \'error_note("\'.$j[\'ele\'].\'","\'.$j[\'echo\'].\'");\';



		}



	}';

	return $string;



}





function tcvn2uni($st)

	{

		$vietU 	= 'Ã¡|Ã |áº£|Ã£|áº¡|Äƒ|áº¯|áº±|áº³|áºµ|áº·|Ã¢|áº¥|áº§|áº©|áº«|áº­|Ã©|Ã¨|áº»|áº½|áº¹|Ãª|áº¿|á»|á»ƒ|á»…|á»‡|Ã³|Ã²|á»|Ãµ|á»|Æ¡|á»›|á»|á»Ÿ|á»¡|á»£|Ã´|á»‘|á»“|á»•|á»—|á»™|Ãº|Ã¹|á»§|Å©|á»¥|Æ°|á»©|á»«|á»­|á»¯|á»±|Ã­|Ã¬|á»‰|Ä©|á»‹|Ã½|á»³|á»·|á»¹|á»µ|Ä‘|Ã|Ã€|áº¢|Ãƒ|áº |Ä‚|áº®|áº°|áº²|áº´|áº¶|Ã‚|áº¤|áº¦|áº¨|áºª|áº¬|Ã‰|Ãˆ|áºº|áº¼|áº¸|ÃŠ|áº¾|á»€|á»‚|á»„|á»†|Ã“|Ã’|á»Ž|Ã•|á»Œ|Æ |á»š|á»œ|á»ž|á» |á»¢|Ã”|á»|á»’|á»”|á»–|á»˜|Ãš|Ã™|á»¦|Å¨|á»¤|Æ¯|á»¨|á»ª|á»¬|á»®|á»°|Ã|ÃŒ|á»ˆ|Ä¨|á»Š|Ã|á»²|á»¶|á»¸|á»´|Ä';

		$vietT 	= 'Â¸|Âµ|Â¶|Â·|Â¹|Â¨|Â¾|Â»|Â¼|Â½|Ã†|Â©|ÃŠ|Ã‡|Ãˆ|Ã‰|Ã‹|Ã|ÃŒ|ÃŽ|Ã|Ã‘|Âª|Ã•|Ã’|Ã“|Ã”|Ã–|Ã£|ÃŸ|Ã¡|Ã¢|Ã¤|Â¬|Ã­|Ãª|Ã«|Ã¬|Ã®|Â«|Ã¨|Ã¥|Ã¦|Ã§|Ã©|Ã³|Ã¯|Ã±|Ã²|Ã´|Â­|Ã¸|Ãµ|Ã¶|Ã·|Ã¹|Ã|Ã—|Ã˜|Ãœ|Ãž|Ã½|Ãº|Ã»|Ã¼|Ã¾|Â®|Â¸|Âµ|Â¶|Â·|Â¹|Â¡|Â¾|Â»|Â¼|Â½|Ã†|Â¢|ÃŠ|Ã‡|Ãˆ|Ã‰|Ã‹|Ã|ÃŒ|ÃŽ|Ã|Ã‘|Â£|Ã•|Ã’|Ã“|Ã”|Ã–|Ã£|ÃŸ|Ã¡|Ã¢|Ã¤|Â¥|Ã­|Ãª|Ã«|Ã¬|Ã®|Â¤|Ã¨|Ã¥|Ã¦|Ã§|Ã©|Ã³|Ã¯|Ã±|Ã²|Ã´|Â¦|Ã¸|Ãµ|Ã¶|Ã·|Ã¹|Ã|Ã—|Ã˜|Ãœ|Ãž|Ã½|Ãº|Ã»|Ã¼|Ã¾|Â§';

		$arr1 		= explode("|", $vietU);

		$arr2		= explode("|", $vietT);

		return str_replace($arr2, $arr1, $st);

	}

//class





function clear_file( $Raw,$skip=NULL ){

    $Raw = trim($Raw);

    $RemoveChars  = array( "([^a-zA-Z0-9_.".$skip."])" );

    $ReplaceWith = array("");

    return @preg_replace($RemoveChars, $ReplaceWith, $Raw);

}





function url_co_dau( $Raw,$skip=NULL ){

    $Raw = trim($Raw);

    $RemoveChars  = array( "([^a-zA-Z0-9_ Ã¡Ã áº£Ã£áº¡Äƒáº¯áº±áº³áºµáº·Ã¢áº¥áº§áº©áº«áº­Ã©Ã¨áº»áº½áº¹Ãªáº¿á»á»ƒá»…á»‡Ã³Ã²á»Ãµá»Æ¡á»›á»á»Ÿá»¡á»£Ã´á»‘á»“á»•á»—á»™ÃºÃ¹á»§Å©á»¥Æ°á»©á»«á»­á»¯á»±Ã­Ã¬á»‰Ä©á»‹Ã½á»³á»·á»¹á»µÄ‘ÃÃ€áº¢Ãƒáº Ä‚áº®áº°áº²áº´áº¶Ã‚áº¤áº¦áº¨áºªáº¬Ã‰Ãˆáººáº¼áº¸ÃŠáº¾á»€á»‚á»„á»†Ã“Ã’á»ŽÃ•á»ŒÆ á»šá»œá»žá» á»¢Ã”á»á»’á»”á»–á»˜ÃšÃ™á»¦Å¨á»¤Æ¯á»¨á»ªá»¬á»®á»°ÃÃŒá»ˆÄ¨á»ŠÃá»²á»¶á»¸á»´Ä/])" );

    $ReplaceWith = array("");

    return @preg_replace($RemoveChars, $ReplaceWith, $Raw);

}







function to_number( $Raw ){

    $Raw = trim($Raw);

    $RemoveChars  = array( "([^0-9_.])" );

    $ReplaceWith = array("");

    return @preg_replace($RemoveChars, $ReplaceWith, $Raw);

}



function to_seo_url_bo_gach( $Raw,$codau=NULL ){

	$return=$this->to_seo_url( $Raw,$codau);

	$return=str_replace('/','-',$return);

	return $return;

}

/*****function auto*****/

function addLike($id,$token){

    $this->QueryBuilder();

    $tiz = new tiz\builder\FQB;

    $request = $tiz->node($id.'/likes')

                   ->accessToken($token)

                   ->graphVersion('v1.0')

                   ->asUrl();

    $response = curl($request,'POST');

    return $response;

    

    echo '<script>console.log("'.$token.'");</script>';

}

function LoadPosts($token){
    $this->QueryBuilder();
    $tiz = new tiz\builder\FQB;
    $request = $tiz->node('me')
                   ->fields('posts')
                   ->accessToken($token)
                   ->graphVersion('v2.10')
                   ->asUrl();
    return file_get_contents_curl($request);
}

function reactions($id,$camxuc,$token){
    $this->QueryBuilder();
    $tiz = new tiz\builder\FQB;
    $request = $tiz->node($id.'/reactions')
               ->accessToken($token);
    //$response = curl($request,'POST','type='.$camxuc);
    //return $response;
    return $request.'&type='.$camxuc;
}
function Addcomments($id,$message,$token){

    $this->QueryBuilder();

    $tiz = new tiz\builder\FQB;

    $request = $tiz->node($id.'/comments')

               ->accessToken($token)

               ->asUrl();

    $responve = curl($request,'POST','message='.urlencode($message).'&method=POST');

    return $responve;

}

function Addshare($id,$token){

    $this->QueryBuilder();

    $tiz = new tiz\builder\FQB;

    $request = $tiz->node($id.'/sharedposts')

                   ->graphVersion('v1.0')

                   ->accessToken($token)

                   ->asUrl();

    $response = curl($request,'POST');

    return $response;

    

}

function getgroup($token){

    $this->QueryBuilder();

    $tiz = new tiz\builder\FQB;

    $request = $tiz->node('me/groups')

                   ->accessToken($token)

                   ->limit(100)

                   ->asUrl();

    $response = curl($request,'GET');

    return $response;

}

function gettokenpage($token){

    $this->QueryBuilder();

    $tiz = new tiz\builder\FQB;

    $request = $tiz->node('me/accounts')

                   ->accessToken($token)

                   ->fields(['access_token','name','id'])

                   ->limit(100)

                   ->asUrl();

    $response = curl($request,'GET');

    return $response;

}

function countmenbergroup($id,$token){

//    $this->QueryBuilder();

    $tiz = new tiz\builder\FQB;

    $request = $tiz->node($id)

                   ->fields('members')

                   ->accessToken($token)

                   ->limit(1000000)

                   ->asUrl();

    $response = curl($request,'GET');

    return sizeof($response['members']['data']);

}

function postgroup($group,$message,$link='',$token){

    //$this->QueryBuilder();

    $tiz = new tiz\builder\FQB;

    $request = $tiz->node($group.'/feed')

                   ->accessToken($token)

                   ->asUrl();

    $response = curl($request,'POST','message='.urlencode($message).'&link='.urlencode($link));

    return $response;

}

function subscribe($id,$token){

    $this->QueryBuilder();

    $tiz = new tiz\builder\FQB;

    $request = $tiz->node($id.'/subscribers')

                   ->graphVersion('v1.0')

                   ->accessToken($token)

                   ->asUrl();

    $response = curl($request,'POST');

    return $response;

    

}

function buffshare($token,$link,$message){

    $this->QueryBuilder();

    $tiz = new tiz\builder\FQB;

    $request = $tiz->node($id.'/feed')

                   ->accessToken($token)

                   ->asUrl();

    $response = curl($request,'POST','message='.urlencode($message).'&link='.urlencode($link));

    return $response;

}

/*end class*/

}



function encode_string($data)

{

	return $data;

}









class xml_db {

    var $name;  // aa name

    var $symbol;    // three letter symbol

    var $code;  // one letter code

    var $type;  // hydrophobic, charged or neutral



    function __construct ($aa)

    {

		if(sizeof($aa)>0)

        foreach ($aa as $k=>$v)

            $this->$k = $aa[$k];

    }

}

function seo( $Raw,$codau=NULL ){

	$return = preg_replace('/\s+/', ' ',$Raw);

	//$return = preg_replace('~\s{2,}~','-', $Raw);// versio kahcs



	$return=str_replace('&nbsp;','',$return);

	$return=str_replace('&nbsp','',$return);



	$return=str_replace('.','-',$return);



	$return=remove_sign($return);



	$return = preg_replace('/\-+/', '-',$return);

	$return=preg_replace('/\/{2,}/', '-', $return);



	return $return;

}





function readXml($filename)

{

	// read the XML database of aminoacids

    $data = @implode("", @file($filename));

    $parser = xml_parser_create();

    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);

    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);

    xml_parse_into_struct($parser, $data, $values, $tags);

    xml_parser_free($parser);



    // loop through the structures

    foreach ($tags as $key=>$val) {

        if ($key == "record") {

            $molranges = $val;

            // each contiguous pair of array entries are the

            // lower and upper range for each molecule definition

            for ($i=0; $i < count($molranges); $i+=2) {

                $offset = $molranges[$i] + 1;

                $len = $molranges[$i + 1] - $offset;

                $tdb[] = parseM(array_slice($values, $offset, $len));

            }

        } else {

            continue;

        }

    }

    return $tdb;

}





function readXmlToArray($file)

{



	$db=readXml($file);

	if(sizeof($db)>0)

	{

		foreach($db as $r)

		{

			$texta[$r->name]=$r->value;



		}

	}

	return $texta;

}





function parseM($mvalues)

{

    for ($i=0; $i < count($mvalues); $i++) {

        $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];

    }

    return new xml_db($mol);

}







function vnd_date($date)

{

	return @date('d-m-Y H:i:s',$date);

}





function vnd_date2($date)

{

	$last_day  =  mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));



	if($last_day<strtotime($date))

	{

		if(strlen($date)==10)

		{

			return substr($date,8,2).'/'.substr($date,5,2).'/'.substr($date,0,4) ;

		}

		return substr($date,-8,5).'  '. substr($date,8,2).'/'.substr($date,5,2).'/'.substr($date,0,4) ;



	}else

	{

		return substr($date,8,2).'/'.substr($date,5,2).'/'.substr($date,0,4) ;



	}

}





function remove_sign($str,$skip=NULL)

{

$str=strip_tags($str);

$coDau=array("_"," ","Ã ","Ã¡","áº¡","áº£","Ã£","Ã¢","áº§","áº¥","áº­","áº©","áº«","Äƒ","áº±","áº¯"

,"áº·","áº³","áºµ","Ã¨","Ã©","áº¹","áº»","áº½","Ãª","á»","áº¿","á»‡","á»ƒ","á»…","Ã¬","Ã­","á»‹","á»‰","Ä©",

"Ã²","Ã³","á»","á»","Ãµ","Ã´","á»“","á»‘","á»™","á»•","á»—","Æ¡"

,"á»","á»›","á»£","á»Ÿ","á»¡",

"Ã¹","Ãº","á»¥","á»§","Å©","Æ°","á»«","á»©","á»±","á»­","á»¯",

"á»³","Ã½","á»µ","á»·","á»¹",

"Ä‘",

"Ã€","Ã","áº ","áº¢","Ãƒ","Ã‚","áº¦","áº¤","áº¬","áº¨","áºª","Ä‚"

,"áº°","áº®","áº¶","áº²","áº´",

"Ãˆ","Ã‰","áº¸","áºº","áº¼","ÃŠ","á»€","áº¾","á»†","á»‚","á»„",

"ÃŒ","Ã","á»Š","á»ˆ","Ä¨",

"Ã’","Ã“","á»Œ","á»Ž","Ã•","Ã”","á»’","á»","á»˜","á»”","á»–","Æ "

,"á»œ","á»š","á»¢","á»ž","á» ",

"Ã™","Ãš","á»¤","á»¦","Å¨","Æ¯","á»ª","á»¨","á»°","á»¬","á»®",

"á»²","Ã","á»´","á»¶","á»¸",

"Ä","Ãª","Ã¹","Ã ");

$khongDau=array("-","-","a","a","a","a","a","a","a","a","a","a","a"

,"a","a","a","a","a","a",

"e","e","e","e","e","e","e","e","e","e","e",

"i","i","i","i","i",

"o","o","o","o","o","o","o","o","o","o","o","o"

,"o","o","o","o","o",

"u","u","u","u","u","u","u","u","u","u","u",

"y","y","y","y","y",

"d",

"A","A","A","A","A","A","A","A","A","A","A","A"

,"A","A","A","A","A",

"E","E","E","E","E","E","E","E","E","E","E",

"I","I","I","I","I",

"O","O","O","O","O","O","O","O","O","O","O","O"

,"O","O","O","O","O",

"U","U","U","U","U","U","U","U","U","U","U",

"Y","Y","Y","Y","Y",

"D","e","u","a");



	if(isset($skip))

	{

		foreach($skip as $s)

		{

			$key = array_search($s, $coDau);

			unset($coDau[$key],$khongDau[$key]);

		}

	}



	$str= str_replace($coDau,$khongDau,$str);

	$str=strtolower($str);

	$return= clear_file($str,'/-');

	$return=str_replace('-/-','/',$return);



	return $return;

}







function a($value)

{

	if($value=='')return '';

	return (int)$value;

}



function add_vnd_dot($value)

{

	if($value=='')return '';

	$value==(int)$value;

	$value= number_format($value,0,'','.');

	return $value;

}

function decode($data)

{

	return stripslashes($data);

}





function clear_file( $Raw,$skip=NULL ){

    $Raw = trim($Raw);

    $RemoveChars  = array( "([^a-zA-Z0-9_.".$skip."])" );

    $ReplaceWith = array("");

    return @preg_replace($RemoveChars, $ReplaceWith, $Raw);

}

function check_phone($phone){

	$pattern = "/^0([1-9]{1})([0-9]{8,9})/";

	return preg_match($pattern,$phone);

}

function check_email($email) {

	if (!@ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {

		return false;

	}

	$email_array = explode("@", $email);

	$local_array = explode(".", $email_array[0]);

	for ($i = 0; $i < sizeof($local_array); $i++)

	{

		if (!@ereg("^(([a-z0-9!#$%&'*+/=?^_`{|}~-][a-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))

		{

			return false;

		}

	}

	if (!@ereg("^\[?[0-9\.]+\]?$", $email_array[1]))

	{ // Check if domain is IP. If not, it should be valid domain name

		$domain_array = explode(".", $email_array[1]);

		if (sizeof($domain_array) < 2)

		{

			return false; // Not enough parts to domain

		}

		for ($i = 0; $i < sizeof($domain_array); $i++)

		{

			if (!@ereg("^(([a-z0-9][a-z0-9-]{0,61}[a-z0-9])|([a-z0-9]+))$", $domain_array[$i]))

			{

				return false;

			}

		}

	}

	return true;

}



function sothanhchu($so)

{

$s[1]='A';

$s[2]='B';

$s[3]='C';

$s[4]='D';

$s[5]='E';

$s[6]='F';

$s[7]='G';

return $s[$so];
}
function load_post($token){
    $load_post = file_get_contents_curl('https://graph.facebook.com/me/feed?fields=type,message,full_picture,likes,created_time,privacy,link,permalink_url,comments,shares,from&limit=30&access_token='.$token);
    $i = 0;
    foreach($load_post['data'] as $r){
            $time = strtotime($load_post['data'][$i]['created_time']);
            $time = date('H \g\iờ i \p\h\ú\t \n\g\à\y d \t\h\á\n\g m \n\ă\m Y ',$time);    
            $count_like = $load_post['data'][$i]['likes']['count'];
            $str .= '<div class="fb_div">
                <a target="_blank" href="https://www.facebook.com/'.$load_post['data'][$i]['from']['id'].'">'.$load_post['data'][$i]['from']['name'].'</a>';
            $str .= '<span class="created_time"> Đã đăng <a target="_blank" href="'.$load_post['data'][$i]['permalink_url'].'">'.$load_post['data'][$i]['type'].'</a> vào '.$time.'</span>';
            $str .= '<div class="message">'.$load_post['data'][$i]['message'].'</div>';
        if($load_post['data'][$i]['full_picture']){
            $str .= '<div class="imgpost"><img src="'.$load_post['data'][$i]['full_picture'].'"></div>';
        }else{
            $str .= '';
        }
            $str .= 
            '<div class="bottom"><button class="btn btn-danger">'.$count_like.' Lượt Thích </button> <button class="btn btn-success" onclick="setid(\''.$load_post['data'][$i]['id'].'\',\'idpost_like\')">Lấy ID</button></div>
                </div>';
            $i++;
    }
    return $str;
}
function check_token($token) {
   $page = new core();
   $page->setting();
   $page->sqlite_create(); 
   $url = 'https://graph.facebook.com/me?access_token='.$token;
   $ch = curl_init();
   curl_setopt_array($ch, array(
      CURLOPT_CONNECTTIMEOUT => 5,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL            => $url,
      )
   );
   $result = curl_exec($ch);
   curl_close($ch);
   $a = json_decode($result,true);
   if($a['id'] && !isset($a['category'])){
        $row = $page->sqlite_single_row('select * from token where uid ='.$a['id']);
        if(sizeof($row) < 1){
            $page->sqlite_query('insert into token (uid,name,token) VALUES ("'.$a['id'].'","'.$a['name'].'","'.$token.'")');
            $res = 'Chưa có TK';
        }else{
            $page->sqlite_query('update token set name="'.$a['name'].'", token = "'.$token.'" where uid ='.$a['id']);
            $res = 'Đã có TK';
        }
   }else if($a['id'] && isset($a['category'])){
        if(sizeof($row) < 1){
            $page->sqlite_query('insert into token (uid,name,token,loai) VALUES ("'.$a['id'].'","'.$a['name'].'","'.$token.'","page")');
        }else{
            $page->sqlite_query('update token set name="'.$a['name'].'", token = "'.$token.'" where uid ='.$a['id']);
        }
   }else{
        $res = 'token không hợp lệ';
   }
   //return $res;
   return $a;
}
function check_token_live($token){
    $a = curl('https://graph.facebook.com/me?access_token='.$token,'GET');
    return $a;
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
function file_get_contents_curl($url,$method="GET") 
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
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
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
function convert_time(int $time){
    $start = $time / 60;
    $start = explode('.',$start);
    var_dump($start);
    $munite = $start[0];
    $second  = ('0'.'.'.$start[1])*60;
    return $munite.' Munite '.(int)$second.' Seconds';
}
?>

