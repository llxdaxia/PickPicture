<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/15
 * Time: 22:15
 */
include '../config/connect_pdo.php';
include '../config/request.php';

$base_url = "http://pic.sogou.com/pics?query=";

$word = $_POST['word'];
$page = $_POST['page'] * 48;
$author_id = $_POST['author_id'];

$url = $base_url . $word . '&start=' . $page . '&reqType=ajax&reqFrom=result';

$response = getRequest($url);
$response = mb_convert_encoding($response, 'UTF-8', array('UTF-8', 'ASCII', 'EUC-CN', 'CP936', 'BIG-5', 'GB2312', 'GBK'));

$response_json = json_decode($response, true, 5000);
if (empty($response_json)) {
    echo "失败\n";
    echo json_last_error() . "\n";
}
$items = $response_json['items'];

foreach ($items as $item) {

    $name = $item['title'];
    $intro = $item['markedTitle'];
    $width = $item['width'];
    $height = $item['height'];
    $src = $item['pic_url'];
    $tag = $word;

    $current_time = date("Y-m-d h:i:s");

    $sql = "INSERT INTO picture (name,intro,width,height,src,author_id,tag,create_time) 
VALUES ('$name','$intro','$width','$height','$src','$author_id','$tag','$current_time')";

    $result_sql = $pdo_connect->exec($sql);
    if ($result_sql) {
        echo "insert success" . "\n";
    } else {
        echo "insert failed" . "\n";
    }
}