<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/16
 * Time: 0:34
 */
require_once __DIR__ . '/../autoload.php';

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
$limit = 3;

list($iterms, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit);
if ($err !== null) {
    echo "\n====> list file err: \n";
    var_dump($err);
} else {
    echo "Marker: $marker\n";
    echo "\nList Iterms====>\n";
    var_dump($iterms);
}
