<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 21:19
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/header.php';
include '../config/token.php';

$src = $_POST['src'];
$name = $_POST['name'];
$intro = $_POST['intro'];
$height = $_POST['height'];
$width = $_POST['width'];
$album_id = $_POST['album_id'];
$tag = $_POST['tag'];

$headers = getallheaders();
$UID = get_UID($headers);
$token = get_token($headers);
check_token_past_due($token);

check_empty($src, $name, $intro, $height, $width, $album_id, $tag,$UID);

$query_sql = "INSERT INTO picture (src,name,intro,height,width,album_id,tag,author_id) 
VALUES ('$src','$name','$intro','$height','$width','$album_id','$tag','$UID')";

$query_result = $pdo_connect->exec($query_sql);

//echo json_encode($pdo_connect->errorInfo());

if ($query_result) {
    $result['info'] = "success";
} else {
    $result['info'] = "insert failed";
}

echo json_encode($result);