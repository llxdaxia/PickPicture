<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/6
 * Time: 10:50
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/token.php';
include '../config/header.php';

$headers = getallheaders();
$uid = get_UID($headers);
$token = get_token($headers);

$number = $_POST['number'];

check_token_past_due($token);
check_empty($uid,$token,$number);

$query_sql = "SELECT * FROM user WHERE number = '$number' LIMIT 1";
$query_result = $pdo_connect->query($query_sql);
if($query_result->rowCount()){
    $result['exit'] = "true";
}else{
    $result['exit'] = "false";
}

echo json_encode($result);