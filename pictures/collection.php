<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/9
 * Time: 15:39
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/header.php';
include '../config/token.php';
include '../config/statusCode.php';

$headers = getallheaders();
$UID = get_UID($headers);
$token = get_token($headers);

check_token_past_due($token);
$photo_id = $_POST['id'];   //收藏图片id

check_empty($photo_id);

//判断是否已经收藏
$is_collection_sql = "SELECT * FROM picture_collection WHERE user_id = '$UID' AND photo_id = '$photo_id'";
$result_is_collection = $pdo_connect->query($is_collection_sql);
if($result_is_collection->rowCount()){
    $result['info'] = "已经收藏过了";
    echo json_encode($result);
    exit();
}


//修改picture表collection_count字段
$modify_collection_count_sql = "UPDATE picture SET  collection_count = collection_count + 1 WHERE id = '$photo_id'";
$pdo_connect->exec($modify_collection_count_sql);

//收藏关系表添加数据
$query_sql = "INSERT INTO picture_collection (user_id,photo_id) VALUES ($UID,$photo_id)";
$query_result = $pdo_connect->exec($query_sql);
if ($query_result) {
    $result['info'] = "success";
} else {
    serverError();
}

echo json_encode($result);