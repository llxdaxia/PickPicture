<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/9
 * Time: 15:55
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

check_empty($star_id);

$query_sql = "DELETE FROM follow WHERE start = '$star_id' AND fans = '$UID'";

$result_query = $pdo_connect->exec($query_sql);

if ($result_query) {
    $result['info'] = success;
} else {
    serverError();
}

echo json_encode($result);