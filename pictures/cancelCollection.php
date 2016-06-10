<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/9
 * Time: 15:40
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/header.php';
include '../config/token.php';
include '../config/statusCode.php';

$headers = getallheaders();
$UID = get_UID($headers);
$token = get_token($headers);

check_token_past_due($token);

$photo_id = $_POST['id'];   //收藏图片id

check_empty($photo_id);

$query_sql = "DELETE FROM picture_collection WHERE user_id = '$UID' AND photo_id = '$photo_id'";
$query_result = $pdo_connect->exec($query_sql);
if ($query_result) {
    $result['info'] = "success";
} else {
    serverError();
}

echo json_encode($result);