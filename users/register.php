<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/2
 * Time: 16:33
 */

include '../config/connect_pdo.php';
include '../config/token.php';
include '../config/check.php';

$name = $_REQUEST['name'];
$password = $_REQUEST['password'];
$code = $_REQUEST['code'];
$number = $_REQUEST['number'];
$avatar = $_REQUEST['avatar'];

check_empty($name, $password, $code, $number, $avatar);
check_has_exist($pdo_connect, "user", "number", $number);
check_has_exist($pdo_connect, "user", "name", $name);

$token = new Token();
$real_token_str = $token->get_token($name, "pick_picture"); //生成token

$insert_sql = "insert into user (name,password,number,avatar,token) 
values('$name','$password','$number','$avatar','$real_token_str')";
$insert_user = $pdo_connect->exec($insert_sql);

if ($insert_user) {
    $result['info'] = "success";
} else {
    $result['info'] = "failed";
}

echo json_encode($result);
