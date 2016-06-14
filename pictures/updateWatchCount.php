<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/14
 * Time: 18:44
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/statusCode.php';
include '../config/header.php';

$id = $_POST['id'];

$update_sql = "UPDATE picture SET watch_count = watch_count + 1 WHERE id = '$id'";
$row = $pdo_connect->exec($update_sql);
if ($row) {
    $result['info'] = "success";
} else {
    $result['info'] = "failed";
}

echo json_encode($result);