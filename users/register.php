<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/2
 * Time: 16:33
 */

include '../config/connect_pdo.php';
include 'token.php';

$name = $_REQUEST['name'];
$password = $_REQUEST['password'];
$code = $_REQUEST['code'];
$number = $_REQUEST['number'];
$avatar = $_REQUEST['avatar'];

if ($name == "" || $password == "" || $code == "" || $number == "" || $avatar == "") {
    header("http/1.1 400 Bad Request");
    $result["error"] = "参数不能为空";
} else {

    $query_sql = "SELECT * FROM user WHERE number = $number";
    $check_repeat = $pdo_connect_db->exec($query_sql);    //返回影响的条目数
    echo $pdo_connect_db->errorCode();
    echo $pdo_connect_db->errorInfo();
    if ($check_repeat) {
        $result['info'] = "已注册";
    } else {

        $token = new token();
        $token_str = $token->get_token($name, "go");

        $insert_sql = "insert into user (name,password,number,avatar,token) values('$name','$password','$number','$avatar','$token_str')";
        $insert_user = $pdo_connect_db->exec($insert_sql);
        echo $pdo_connect_db->errorCode();
        echo $pdo_connect_db->errorInfo();
        if ($insert_user) {
            $result['info'] = "success";
        } else {
            $result['info'] = "failed";
        }
    }


}

echo json_encode($result);
