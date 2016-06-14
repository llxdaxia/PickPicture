<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 18:45
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/header.php';
include '../config/token.php';

$avatar = $_POST['avatar'];
$name = $_POST['name'];
$gender = $_POST['gender'];
$background = $_POST['background'];
$intro = $_POST['intro'];

$headers = getallheaders();

$id = get_UID($headers);
$token = get_token($headers);
check_token_past_due($token);

check_empty($avatar, $name, $gender, $intro);

$query_sql = "UPDATE user SET avatar = '$avatar',name = '$name',gender = $gender,
background = '$background',intro = '$intro' WHERE id = '$id'";
$query_result = $pdo_connect->exec($query_sql);

if ($query_result) {
    $result['info'] = "success";
} else {
    $result['info'] = "info not modify";
}

echo json_encode($result);

