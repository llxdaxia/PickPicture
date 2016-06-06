<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 17:01
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/token.php';
include '../config/header.php';
include '../config/statusCode.php';

$headers = getallheaders();
$uid = get_UID($headers);
$token = get_token($headers);

check_token_past_due($token);

$id = $_POST['id'];

check_empty($id);
check_not_exist($pdo_connect, "user", "id", $id,"用户不存在");

$query_sql = "SELECT * FROM user WHERE id = $id LIMIT 1";
$query_result = $pdo_connect->query($query_sql);
if (empty($query_result)) {
    serverError();
}
if ($query_result->rowCount() == 0) {
    $result['info'] = "id is not exist";
} else {

    //查询图片集
    $query_picture = "SELECT src FROM picture WHERE author_id = '$id'";
    $picture_result = $pdo_connect->query($query_picture);

    $index = 0;
    foreach ($picture_result as $item) {
        $picture_array[$index] = $item['src'];
        $index++;
    }

    //查询相册
    $query_album = "SELECT avatar FROM album WHERE author_id = '$id'";
    $album_result = $pdo_connect->query($query_album);

    $index = 0;
    foreach ($album_result as $item) {
        $album_array[$index] = $item['avatar'];
        $index++;
    }

    foreach ($query_result as $item) {
        $result['id'] = $item['id'];
        $result['number'] = $item['number'];
        $result['name'] = $item['name'];
        $result['avatar'] = $item['avatar'];
        $result['gender'] = $item['gender'];
        $result['intro'] = $item['intro'];
        $result['pictures'] = $picture_array;
        $result['albums'] = $album_array;
    }
}

echo json_encode($result);
