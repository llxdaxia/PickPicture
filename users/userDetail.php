<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 17:01
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/statusCode.php';
include '../config/header.php';

$headers = getallheaders();
$UID = get_UID($headers);

$id = $_POST['id'];

check_empty($id);
check_not_exist($pdo_connect, "user", "id", $id, "用户不存在");

//查询图片集，获取用户所有图片
$query_picture = "SELECT * FROM picture WHERE author_id = '$id' ORDER BY create_time DESC";
$result_query = $pdo_connect->query($query_picture);
$rows = $result_query->fetchAll();

$avatar_sql = "SELECT * FROM user WHERE id = '$id' LIMIT 1";
$result_avatar = $pdo_connect->query($avatar_sql);
$author = $result_avatar->fetch();
$author_avatar = $author['avatar'];
$author_name = $author['name'];

$result = array();
$picture_array = array();
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

    $picture_array[$index] = $picture;
    $index++;
}


//查询专辑
$query_album = "SELECT avatar FROM album WHERE author_id = '$id'";
$album_result = $pdo_connect->query($query_album);

$album_array = array();
$index = 0;
foreach ($album_result as $item) {
    $album_array[$index] = $item['avatar'];
    $index++;
}


//整合结果
$query_sql = "SELECT * FROM user WHERE id = $id LIMIT 1";
$query_result = $pdo_connect->query($query_sql);
$item = $query_result->fetch();

$result = array();

//echo $id . "\n";
//echo $UID . "\n";

//是否被关注
$is_star_sql = "SELECT * FROM follow WHERE star = '$id' AND fans = '$UID'";
$result_is_star = $pdo_connect->query($is_star_sql);

$result['id'] = $item['id'];
$result['number'] = $item['number'];
$result['name'] = $item['name'];
$result['avatar'] = $item['avatar'];
$result['gender'] = $item['gender'];
$result['intro'] = $item['intro'];
$result['pictures'] = $picture_array;
$result['albums'] = $album_array;
$result['is_followed'] = $result_is_star->rowCount() > 0;


echo json_encode($result);
