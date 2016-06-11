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

$query_sql = "SELECT * FROM picture WHERE author_id = '$id'";

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
    $picture['id'] = $item['id'];
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
    $picture['create_time'] = $item['create_time'];
    $picture['author_avatar'] = $author_avatar;
    $picture['author_name'] = $author_name;
    $picture['author_picture_count'] = $result_query->rowCount();

    $result[$index] = $picture;
    $index++;
}

echo json_encode($result);