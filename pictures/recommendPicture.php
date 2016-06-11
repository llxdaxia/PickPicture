<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 13:00
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/statusCode.php';

$page = $_REQUEST['page'];

check_empty($page);

$start = ($page - 1) * 20;
$end = $page * 20;

$query_sql = "SELECT * FROM picture LIMIT $start,$end";
$query_result = $pdo_connect->query($query_sql);

$result = array();
if ($query_result->rowCount()) {
    $result_rows = $query_result->fetchAll();

    $index = 0;
    foreach ($result_rows as $row) {

        $author_id = $row['author_id'];
        
        $picture['id'] = $row['id'];
        $picture['name'] = $row['name'];
        $picture['intro'] = $row['intro'];
        $picture['width'] = $row['width'];
        $picture['height'] = $row['height'];
        $picture['src'] = $row['src'];
        $picture['author_id'] = $row['author_id'];
        $picture['tag'] = $row['tag'];
        $picture['score'] = $row['score'];
        $picture['watch_count'] = $row['watch_count'];
        $picture['collection_count'] = $row['collection_count'];
        $picture['album_id'] = $row['album_id'];
        $picture['create_time'] = strtotime($row['create_time']);
        
        //获取作者的头像和昵称
        $avatar_sql = "SELECT * FROM user WHERE id = '$author_id' LIMIT 1";
        $result_avatar = $pdo_connect->query($avatar_sql);
        $author = $result_avatar->fetch();
        $author_avatar = $author['avatar'];
        $author_name = $author['name'];
        
        $picture['author_avatar'] = $author_avatar;
        $picture['author_name'] = $author_name;
        
        //获取作者发布的图片数量
        $picture_count_sql = "SELECT * FROM picture WHERE author_id = '$author_id'";
        $result_count = $pdo_connect->query($picture_count_sql);
        $result_count->fetchAll();
        $picture['author_picture_count'] = $result_count->rowCount();;

        $result[$index] = $picture;
        $index++;
    }
} else {
    serverError();
}

echo json_encode($result);