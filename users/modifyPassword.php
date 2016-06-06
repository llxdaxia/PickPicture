<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/6
 * Time: 10:26
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/token.php';
include '../config/header.php';

$headers = getallheaders();
$uid = get_UID($headers);
$token = get_token($headers);

$number = $_POST['number'];
$password = $_POST['password'];
$code = $_POST['code'];

check_token_past_due($token);
check_empty($uid,$token,$number,$password,$code);

$query_sql = "UPDATE user SET number = '$number',password = '$password' WHERE id = '$uid'";
$query_result = $pdo_connect->exec($query_sql);
if($query_result){
    $result['info'] = "success";
}else{
    $result['info'] = "failed";
}

echo json_encode($result);