<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 13:14
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/header.php';
include '../config/token.php';
include '../config/statusCode.php';

$headers = getallheaders();
$uid = $headers['UID'];
$token = get_token($headers);

$picture_id = $_REQUEST['id'];

check_token_past_due($token);
check_empty($picture_id);
check_not_exist($pdo_connect, "picture", "id", $picture_id, "图片不存在");

$picture_tag_sql = "SELECT * FROM picture WHERE id = '$picture_id' LIMIT 1";  //取出图片tag

$result_picture_tag = $pdo_connect->query($picture_tag_sql);
$tag_row = $result_picture_tag->fetch();

$watch_count = $tag_row['watch_count'] + 1;
$update_picture_sql = "UPDATE picture SET watch_count = '$watch_count'";
$pdo_connect->exec($update_picture_sql);

$result['id'] = $picture_id;
$result['name'] = $tag_row['name'];
$result['intro'] = $tag_row['intro'];
$result['width'] = $tag_row['width'];
$result['height'] = $tag_row['height'];
$result['src'] = $tag_row['src'];
$result['author_id'] = $tag_row['author_id'];
$result['tag'] = $tag_row['tag'];
$result['score'] = $tag_row['score'];
$result['watch_count'] = $tag_row['watch_count'];
$result['collection_count'] = $tag_row['collection_count'];
$result['album_id'] = $tag_row['album_id'];
$result['create_time'] = strtotime($tag_row['create_time']);

//用户未登录，直接返回
if ($uid == "") {
    echo json_encode($result);
    exit();
}

$picture_tag = $tag_row['tag'];

$split_array = explode('，', $picture_tag);

$isSuccess = true;

//遍历图片TAG，更新用户TAG
foreach ($split_array as $tag_name) {
    $user_tag_sql = "SELECT score FROM tag WHERE author_id = '$uid' AND name = '$tag_name' LIMIT 1";
    $result_user_tag = $pdo_connect->query($user_tag_sql);
    $result_tag = $result_user_tag->fetch();
    if (empty($result_tag)) {
        $insert_sql = "INSERT INTO tag (name,score,author_id) VALUES ('$tag_name','1','$uid')";
        $result_insert = $pdo_connect->exec($insert_sql);
        if ($result_insert) {
            $isSuccess = false;
        }
    } else {
        $score = $result_tag['score'] + 1;
        $update_sql = "UPDATE tag SET score = '$score' WHERE author_id = '$uid' AND name = '$tag_name' LIMIT 1";
        $result_update = $pdo_connect->exec($update_sql);
        if ($result_update) {
            $isSuccess = false;
        }
    }
}

echo json_encode($result);


