<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/2
 * Time: 16:33
 */

include '../config/connect_pdo.php';
include 'token.php';
include '../config/check_param_empty.php';

$name = $_REQUEST['name'];
$password = $_REQUEST['password'];
$code = $_REQUEST['code'];
$number = $_REQUEST['number'];
$avatar = $_REQUEST['avatar'];

check_empty($name, $password, $code, $number, $avatar);

$query_sql = "SELECT * FROM user WHERE number='$number' OR name='$name'";
$check_repeat = $pdo_connect_db->query($query_sql);    //返回影响的条目数

if ($check_repeat->rowCount() > 0) {
    $result['info'] = "已注册";
} else {

    $token = new token();
    $token_str = $token->get_token($name, "go");

    $insert_sql = "insert into user (name,password,number,avatar,token) values('$name','$password','$number','$avatar','$token_str')";
    $insert_user = $pdo_connect_db->exec($insert_sql);

    if ($insert_user) {
        $result['info'] = "success";
    } else {
        $result['info'] = "failed";
    }
}

echo json_encode($result);
