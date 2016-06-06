<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 13:14
 */

include '../config/connect_pdo.php';
include '../config/check.php';

$id = $_REQUEST['id'];

check_empty($id);
check_not_exist($pdo_connect, "picture", "id", $id);

$query_tag = "SELECT tag FROM picture WHERE id = '$id'";
$result_tag = $pdo_connect->query($query_tag);
$tag_array = $result_tag->fetch();
$tag = $tag_array['tag'];

$split_array = explode(',', $tag);

echo json_encode($split_array);


