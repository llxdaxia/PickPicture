<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/14
 * Time: 12:25
 */

include "./v1/config/connect_pdo.php";
include './v1/config/check.php';
include './v1/config/header.php';
include './v1/config/token.php';

$user_id = $_POST['id'];

//获取作者信息
$query_sql = "SELECT * FROM  user WHERE id = '$user_id'";

$result_query = $pdo_connect->query($query_sql);
$pictures = $result_query->fetchAll();

//获取作者发布的图片数量
$picture_count_sql = "SELECT * FROM picture WHERE author_id = '$user_id'";
$picture_count = $pdo_connect->query($picture_count_sql);

$result = array();
$index = 0;
foreach ($pictures as $row) {
    $photo_id = $row['photo_id'];

    $picture_sql = "SELECT * FROM picture WHERE id = '$photo_id' LIMIT 1";

    $result_picture = $pdo_connect->query($picture_sql);
    $picture = $result_picture->fetch();

    $collection_sql = "SELECT * FROM picture_collection WHERE user_id = '$user_id' AND photo_id = '$photo_id' LIMIT 1";
    $result_collection = $pdo_connect->query($collection_sql);

    $item['id'] = $picture['0'];
    $item['name'] = $picture['1'];
    $item['intro'] = $picture['intro'];
    $item['width'] = $picture['width'];
    $item['height'] = $picture['height'];
    $item['src'] = $picture['src'];
    $item['author_id'] = $picture['author_id'];
    $item['tag'] = $picture['tag'];
    $item['score'] = $picture['score'];
    $item['watch_count'] = $picture['watch_count'];
    $item['collection_count'] = $picture['collection_count'];
    $item['album_id'] = $picture['album_id'];
    $item['create_time'] = strtotime($picture['create_time']);
    $item['author_avatar'] = $row['avatar'];
    $item['author_name'] = $row['name'];
    $item['author_picture_count'] = $picture_count->rowCount();
    $item['is_collection'] = $result_collection->rowCount() > 0;

    $result[$index] = $item;
    $index++;
}

echo json_encode($result);

