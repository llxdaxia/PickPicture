<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 23:27
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/header.php';
include '../config/token.php';
include '../config/statusCode.php';

$headers = getallheaders();
$uid = get_UID($headers);
$token = get_token($headers);
check_token_past_due($token);

$id = $_POST['id']; //图片id

check_empty($id);
check_not_exist($pdo_connect, "picture", "id", $id, "图片不存在");

$query_sql = "DELETE FROM picture WHERE id = '$id'";
$query_result = $pdo_connect->exec($query_sql);

if ($query_result) {
    $result['info'] = "success";
} else {
    serverError();
}

echo json_encode($result);