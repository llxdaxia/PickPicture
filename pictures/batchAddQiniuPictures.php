<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/16
 * Time: 0:34
 */
require_once __DIR__ . '/../autoload.php';
include '../Qiniu/Config.php';
include '../Qiniu/Auth.php';
include '../Qiniu/Storage/BucketManager.php';
include '../Qiniu/Http/Client.php';
include '../Qiniu/Http/Request.php';
include '../Qiniu/Http/Response.php';


use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

$accessKey = 'UOUxbo4brbNKkEEkTEZbnkPXrKaq_KoqCxhlo2oe';
$secretKey = '55JlULJtMpRpt-LJuid3gK_7I9CJOVDyhT_-k6sO';
$auth = new Auth($accessKey, $secretKey);
$bucketMgr = new BucketManager($auth);

// 要列取的空间名称
$bucket = 'shadow';

// 要列取文件的公共前缀
$prefix = 'u';

$marker = '';
$limit = 200;

list($iterms, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit);
if ($err !== null) {
    echo "\n====> list file err: \n";
    var_dump($err);
} else {
//    echo "Marker: $marker\n";
//    echo "\nList Iterms====>\n";
//    var_dump($iterms);
    echo json_encode($iterms);
}
