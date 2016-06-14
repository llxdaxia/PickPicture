<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/6
 * Time: 14:58
 */

include '../config/connect_pdo.php';
include '../config/token.php';
include '../config/header.php';

$headers = getallheaders();
$id = get_UID($headers);
$old_token = get_token($headers);

$token = new Token();
$token->prolong_user_token($old_token);

$query_sql = "select * from user where id = '$id' LIMIT 1";
$query_result = $pdo_connect->query($query_sql);
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
    $result["error"] = "没有这个用户";
}

echo json_encode($result);
