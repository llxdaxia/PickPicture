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
    $picture['album_id'] = $album_id;
    $picture['create_time'] = $item['create_time'];
    $picture['author_avatar'] = $item['author_avatar'];
    $picture['author_name'] = $item['author_name'];

    $result[$index] = $picture;
    $index++;
}

echo json_encode($result);