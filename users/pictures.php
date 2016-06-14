<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/6
 * Time: 21:11
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/header.php';

$headers = getallheaders();
$UID = $headers['UID'];  //可能登陆，也可以能没有登陆
$id = $_POST['id'];

$query_sql = "SELECT * FROM picture JOIN user ON author_id = '$id' AND 
user.id = '$id' ORDER BY create_time DESC";

$result_query = $pdo_connect->query($query_sql);
$rows = $result_query->fetchAll();

$result = array();
$index = 0;
foreach ($rows as $item) {

    $photo_id = $item['0'];

    //是否被收藏
    if (!empty($UID)) {
        $collection_sql = "SELECT * FROM picture_collection WHERE user_id = '$UID' AND photo_id = '$photo_id' LIMIT 1";
        $result_is_collection = $pdo_connect->query($collection_sql);
        $picture['is_collection'] = $result_is_collection->rowCount() > 0;
    }

    $picture['id'] = $photo_id;
    $picture['name'] = $item['1'];
    $picture['gender'] = $item['gender'];
    $picture['intro'] = $item['2'];
    $picture['width'] = $item['width'];
    $picture['height'] = $item['height'];
    $picture['src'] = $item['src'];
    $picture['author_id'] = $item['author_id'];
    $picture['tag'] = $item['tag'];
    $picture['score'] = $item['score'];
    $picture['watch_count'] = $item['watch_count'];
    $picture['collection_count'] = $item['collection_count'];
    $picture['album_id'] = $item['album_id'];
    $picture['create_time'] = strtotime($item['create_time']);
    $picture['author_avatar'] = $item['avatar'];
    $picture['author_name'] = $item['name'];
    $picture['author_picture_count'] = $result_query->rowCount();

    $result[$index] = $picture;
    $index++;
}

echo json_encode($result);