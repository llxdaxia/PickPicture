<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/16
 * Time: 12:07
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/header.php';
include '../config/token.php';
include '../config/statusCode.php';

require('../include.php');
use TencentYoutuyun\Youtu;
use TencentYoutuyun\Conf;

// 设置APP 鉴权信息
$appid = '1007268';
$secretId = 'AKIDol3hHtHrhSZuDCFSCEr0DQCBoyBDlOEf';
$secretKey = '55jtu8MH5BNHl9gPgDQLTc9NPRpmaiJ1';
$userid = '973829691';
Conf::setAppInfo($appid, $secretId, $secretKey, $userid, conf::API_YOUTU_END_POINT);

//把数据库所有图片取出来
$sql = "SELECT * FROM picture";
$result_sql = $pdo_connect->query($sql);
$rows = $result_sql->fetchAll();

foreach ($rows as $row) {
    $photo_id = $row['id'];  //图片id

    echo $photo_id . "\n";

    $url = $row['src'];
    $result = YouTu::imagetagurl($url);
    $tags = $result['tags'];

    $length = count($tags);
    $tags_str = "";
    for ($i = 0; $i < $length; $i++) {
        $tag_name = $tags[$i]['tag_name'];

        if ($i == 0) {
            $tags_str = $tag_name;
            $name_sql = "UPDATE picture SET name = '$tag_name' WHERE id = '$photo_id' ";
            $result_name = $pdo_connect->exec($name_sql);
        } else {
            $tags_str = $tags_str . ',' . $tag_name;
        }

        echo "tag : " . $tag_name . "\n";
    }

    $current_time = date("Y-m-d h:i:s");
    $tag_sql = "UPDATE picture SET tag = '$tags_str',create_time = '$current_time' WHERE id = '$photo_id' ";
    $result_tag = $pdo_connect->exec($tag_sql);
    if ($result_tag) {
        echo "success\n";
    } else {
        echo "failed\n";
    }
}