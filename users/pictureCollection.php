<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/14
 * Time: 12:25
 */

include "../config/connect_pdo.php";
include '../config/check.php';
include '../config/token.php';

$headers = getallheaders();
$UID = $headers['UID'];  //可能登陆，也可以能没有登陆

$user_id = $_POST['id'];

//获取收藏的图片
$query_sql = "SELECT photo_id FROM picture_collection WHERE user_id = '$user_id'";
$result_query = $pdo_connect->query($query_sql);
$pictures = $result_query->fetchAll();

//获取作者信息
$avatar_sql = "SELECT * FROM user WHERE id = '$user_id' LIMIT 1";
$result_avatar = $pdo_connect->query($avatar_sql);
$author = $result_avatar->fetch();
$author_avatar = $author['avatar'];
$author_name = $author['name'];

//获取作者发布的图片数量
$picture_count_sql = "SELECT * FROM picture WHERE author_id = '$user_id'";
$picture_count = $pdo_connect->query($picture_count_sql);


$index = 0;
foreach ($pictures as $row) {
    $photo_id = $row['photo_id'];

    //获取图片信息
    $picture_sql = "SELECT * FROM picture WHERE id = '$photo_id' LIMIT 1";
    $result_picture = $pdo_connect->query($picture_sql);
    $picture = $result_picture->fetch();

    //是否被收藏
    if (!empty($UID)) {
        $collection_sql = "SELECT * FROM picture_collection WHERE user_id = '$UID' AND photo_id = '$photo_id' LIMIT 1";
        $result_is_collection = $pdo_connect->query($collection_sql);
        $item['is_collection'] = $result_is_collection->rowCount() > 0;
    }

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
    $item['author_picture_count'] = $picture_count->rowCount();

    $result[$index] = $item;
    $index++;
}

echo json_encode($result);

