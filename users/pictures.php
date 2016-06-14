<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/6
 * Time: 21:11
 */

include '../config/connect_pdo.php';
include '../config/check.php';

$id = $_POST['id'];

$query_sql = "SELECT * FROM picture WHERE author_id = '$id' ORDER BY create_time DESC";

$result_query = $pdo_connect->query($query_sql);
$rows = $result_query->fetchAll();

$avatar_sql = "SELECT * FROM user WHERE id = '$id' LIMIT 1";
$result_avatar = $pdo_connect->query($avatar_sql);
$author = $result_avatar->fetch();
$author_avatar = $author['avatar'];
$author_name = $author['name'];

$result = array();
$index = 0;
foreach ($rows as $item) {

    $photo_id = $item['id'];

    $collection_sql = "SELECT * FROM picture_collection WHERE user_id = '$id' AND photo_id = '$photo_id' LIMIT 1";
    $result_is_collection = $pdo_connect->query($collection_sql);

    $picture['id'] = $photo_id;
    $picture['name'] = $item['name'];
    $picture['intro'] = $item['intro'];
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
    $picture['author_avatar'] = $author_avatar;
    $picture['author_name'] = $author_name;
    $picture['author_picture_count'] = $result_query->rowCount();
    $picture['is_collection'] = $result_is_collection->rowCount() > 0;

    $result[$index] = $picture;
    $index++;
}

echo json_encode($result);