<?php
include '../library/common.php';
$page = new core();
$page->querybuilder();
$id = '800514420109224';
$token = 'EAAAAAYsX7TsBAOhFc3pK0bDB2ZB1tcnZBmtF4nEFVge2ZAHyAkL9pZBIEO6tx6KIXuPVlU9RMWU2LK2ZA3Y0EJNBLp4x5qJfUqEToMEx2idRPxB7RlWoQ5oJS2AasdGj4wBGTejRtnmAJiDgkQWPi6FRKkZBSFCzjTu2tEBt7WSwMHJZCyF21kyknV6QG0bWd23FXl57dj36NQqStDts3ZCo';
    $tiz = new SammyK\FacebookQueryBuilder\FQB;
    $request = $tiz->node('me')
                   ->fields('photos{images,name,created_time,link}')
                   ->accessToken($token)
                   ->graphVersion('v2.10')
                   ->asUrl();
                   //$a = curl($request,'GET');
                   $a = file_get_contents_curl($request);
                   echo $a['photos']['data']['1']['images']['1']['source'];
/*echo $comment = $fqb->node('800514420109224/comments')
               ->accessToken($token)
               ->graphVersion('v1.0')
               ->asUrl();
               $a = curl($comment,'POST','method=POST&message='.urlencode("test api comment v1.0").'');
               var_dump($a);
/*$request = $fqb->node('800514420109224/likes')
               ->accessToken($token)
               ->graphVersion('v1.0')
               ->asUrl();
/*$res = $fqb->node('app')
            ->accessToken($token)
            ->asUrl();
            echo $res;*/
//echo $request;
//$a = curl($request,'POST');
//var_dump($a);
//$a = curl($res,'GET');
//echo $a['id'];
//$data = curl($request);
//var_dump($data);
?>