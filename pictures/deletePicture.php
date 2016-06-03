<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 23:27
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/header.php';

$id = $_POST['id'];

check_empty($id);
check_not_exist($pdo_connect, "picture", "id", $id);

$query_sql = "DELETE FROM picture WHERE id = '$id'";
$query_result = $pdo_connect->exec($query_sql);

if ($query_result) {
    $result['info'] = "success";
} else {
    $result['info'] = "delete failed";
}

echo json_encode($result);