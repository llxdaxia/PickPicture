<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/6
 * Time: 18:07
 */

include '../config/connect_pdo.php';
include '../config/check.php';

$id = $_POST['id'];

check_empty($id);
check_not_exist($pdo_connect, "user", "id", $id, "用户不存在");

//根据作者id获取图片专辑id集合
$query_sql = "SELECT DISTINCT album_id FROM picture WHERE author_id = '$id'";

$result_query = $pdo_connect->query($query_sql);
$rows = $result_query->fetchAll();

$result = array();
$index = 0;
foreach ($rows as $row) {
    $album_id = $row['album_id'];   //专辑id

    //通过专辑id获取专辑
    $album_sql = "SELECT * FROM album WHERE id = '$album_id' LIMIT 1";
    $result_album = $pdo_connect->query($album_sql);
    $result_row = $result_album->fetch();

    $album['id'] = $album_id;
    $album['name'] = $result_row['name'];
    $album['avatar'] = $result_row['avatar'];
    $album['author_id'] = $id;
    $album['intro'] = $result_row['intro'];

    //通过专辑id获取专辑图片
    $picture_sql = "SELECT * FROM picture WHERE album_id = '$album_id'";
    $result_picture = $pdo_connect->query($picture_sql);
    $picture_rows = $result_picture->fetchAll();

    $pictures = array();
    $picture_index = 0;
    foreach ($picture_rows as $item) {

        $picture = array();
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

        $pictures[$picture_index] = $picture;
        $picture_index++;
    }

    $album['pictures'] = $pictures;

    $result[$index] = $album;
    $index++;
}

echo json_encode($result);