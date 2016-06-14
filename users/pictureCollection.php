<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/14
 * Time: 12:25
 */

include "../config/connect_pdo.php";
include '../config/check.php';
include '../config/header.php';
include '../config/token.php';

$user_id = $_POST['id'];

$query_sql = "SELECT photo_id FROM picture_collection WHERE user_id = '$user_id'";
$result_query = $pdo_connect->query($query_sql);
$pictures = $result_query->fetchAll();

$avatar_sql = "SELECT * FROM user WHERE id = '$user_id' LIMIT 1";
$result_avatar = $pdo_connect->query($avatar_sql);
$author = $result_avatar->fetch();
$author_avatar = $author['avatar'];
$author_name = $author['name'];

$index = 0;
foreach ($pictures as $row) {
    $photo_id = $row['photo_id'];

//    echo $photo_id."\n";

    $picture_sql = "SELECT * FROM picture WHERE id = '$photo_id' LIMIT 1";

    $result_picture = $pdo_connect->query($picture_sql);
    $picture = $result_picture->fetch();

    $collection_sql = "SELECT * FROM picture_collection WHERE user_id = '$id' AND photo_id = '$photo_id' LIMIT 1";
    $result_is_collection = $pdo_connect->query($collection_sql);

    $item['id'] = $picture['id'];
    $item['name'] = $picture['name'];
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
    $item['author_avatar'] = $author_avatar;
    $item['author_name'] = $author_name;
    $item['author_picture_count'] = $result_query->rowCount();
    $item['is_collection'] = $result_is_collection->rowCount() > 0;

    $result[$index] = $item;
    $index++;
}

echo json_encode($result);

