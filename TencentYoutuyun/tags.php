<?php

require('../include.php');
use TencentYoutuyun\Youtu;
use TencentYoutuyun\Conf;


// 设置APP 鉴权信息
$appid = '1007268';
$secretId = 'AKIDol3hHtHrhSZuDCFSCEr0DQCBoyBDlOEf';
$secretKey = '55jtu8MH5BNHl9gPgDQLTc9NPRpmaiJ1';
$userid = '973829691';


Conf::setAppInfo($appid, $secretId, $secretKey, $userid, conf::API_YOUTU_END_POINT);

//
//// 人脸检测 调用列子
//$uploadRet = YouTu::detectface('http://img04.sogoucdn.com/app/a/100520024/0e4b0e698f91576283de9e63dd868744', 1);
//var_dump($uploadRet);
//
//
//// 人脸定位 调用demo
//$uploadRet = YouTu::faceshape('a.jpg', 1);
//var_dump($uploadRet);

$image_path = '';
$url = 'http://img04.sogoucdn.com/app/a/100520024/0e4b0e698f91576283de9e63dd868744';

//YouTu::imagetag($image_path);
$result = YouTu::imagetagurl($url);

echo json_encode($result);