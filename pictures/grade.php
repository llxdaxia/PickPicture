<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 16:33
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/token.php';
include '../config/header.php';
include '../config/statusCode.php';

$headers = getallheaders();
$uid = get_UID($headers);
$token = get_token($headers);
check_token_past_due($token);

$id = $_POST['id'];
$score = $_POST['score'];

check_empty($id, $score);

$check_sql = "SELECT score FROM picture WHERE id = $id";
$check_result = $pdo_connect->query($check_sql);
$rows_length = $check_result->rowCount();

if ($rows_length == 0) {
    $result['info'] = "id is not exist";
} else {
    foreach ($check_result as $item) {
        if ($item['score'] == $score) {
            $result['info'] = "score the same as old";
            echo json_encode($result);
            exit();
        }
    }

    $query_sql = "UPDATE picture SET score = '$score' WHERE id = '$id'";
    $query_result = $pdo_connect->exec($query_sql);

    if ($query_result) {
        $result['info'] = "success";
    } else {
        serverError();
    }

}

echo json_encode($result);