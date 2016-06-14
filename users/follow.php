<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 18:17
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

$star_id = $_POST['id'];   //被关注者id

check_empty($UID, $star_id);
check_not_exist($pdo_connect, "user", "id", $star_id, "关注者不存在");

$check_sql = "SELECT * FROM follow WHERE star = '$star_id' AND fans = '$UID'";
$check_result = $pdo_connect->query($check_sql);
if ($check_result->rowCount() == 0) {
    $query_sql = "INSERT INTO follow (star,fans) VALUES ('$star_id','$UID')";
    $query_result = $pdo_connect->exec($query_sql);

    if ($query_result) {
        $result['info'] = "success";
    } else {
        serverError();
    }
} else {
    $result['info'] = "the user has been follow";
}

echo json_encode($result);