<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 20:31
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

$id = $_POST['id'];   //可空，如果没有这个属性，表示新建，如果有表示更新此id的信息

$name = $_POST['name'];
$avatar = $_POST['avatar']; 
$intro = $_POST['intro'];

check_empty($name, $avatar, $intro);

if ($id != "") {
    $query_sql = "UPDATE album SET name = '$name',avatar = '$avatar',author_id = '$UID',intro = '$intro'";
} else {
    check_has_exist($pdo_connect, "album", "name", $name);
    $query_sql = "INSERT INTO album (name,avatar,author_id,intro) VALUES ('$name','$avatar','$UID','$intro')";
}

$query_result = $pdo_connect->exec($query_sql);
if ($query_result) {
    $result['info'] = "success";
} else {
    serverError();
}

echo json_encode($result);