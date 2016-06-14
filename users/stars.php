<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/14
 * Time: 16:17
 */


include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/statusCode.php';

$id = $_POST['id'];

$query_sql = "SELECT * FROM follow WHERE fans = '$id'";
$result_sql = $pdo_connect->query($query_sql);
$rows = $result_sql->fetchAll();


$user_index = 0;
$result = array();
foreach ($rows as $row) {
    $user_id = $row['star'];   //粉丝的id

    $avatar_sql = "SELECT * FROM user WHERE id = '$user_id' LIMIT 1";
    $result_avatar = $pdo_connect->query($avatar_sql);
    $temp = $result_avatar->fetch();

    $user = array();
    $user['id'] = $temp['id'];
    $user['number'] = $temp['number'];
    $user['name'] = $temp['name'];
    $user['avatar'] = $temp['avatar'];
    $user['gender'] = $temp['gender'];
    $user['intro'] = $temp['intro'];

    $result[$user_index] = $user;

    $user_index++;
}

echo json_encode($result);