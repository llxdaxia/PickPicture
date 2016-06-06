<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/1
 * Time: 10:40
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/token.php';
include '../config/statusCode.php';

$number = $_POST['number'];
$password = $_POST['password'];

check_empty($number, $password);

$login_sql = "select * from user where number = '$number' and password = '$password' LIMIT 1";
$query_result = $pdo_connect->query($login_sql);
if (empty($query_result)) {
    serverError();
}

if ($query_result->rowCount()) {

    $result_row = $query_result->fetch();

    $id = $result_row['id'];
    $token_str = $result_row['token'];
    $token = new Token();
    $token->set_user_token($token_str, $id);

    $result = array(
        'id' => $id,
        'name' => $result_row ['name'],
        'avatar' => $result_row ['avatar'],
        'gender' => $result_row ['gender'],
        'intro' => $result_row ['intro'],
        'token' => $token_str
    );
} else {
    header("http/1.1 400 params error");
    $result["error"] = "手机号码或密码错误";
}

echo json_encode($result);


