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

$headers = getallheaders();
$UID = $UID = $headers['UID'];;

$page = $_REQUEST['page'];

$page++;
check_empty($page);

$start = ($page - 1) * 20;
$end = $page * 20;

//获取20张最新发布图片
$query_sql = "SELECT DISTINCT * FROM picture INNER JOIN user ON picture.author_id = user.id ORDER BY create_time DESC LIMIT $start,$end";
$query_result = $pdo_connect->query($query_sql);

$result = array();
if ($query_result->rowCount()) {
    $result_rows = $query_result->fetchAll();

    $index = 0;
    foreach ($result_rows as $row) {

        $photo_id = $row['0'];

        if (!empty($UID)) {
            //是否收藏
            $collection_sql = "SELECT * FROM picture_collection WHERE user_id = '$UID' AND photo_id = '$photo_id' LIMIT 1";
            $result_is_collection = $pdo_connect->query($collection_sql);
            $picture['is_collection'] = $result_is_collection->rowCount() > 0;
        }

        $author_id = $row['author_id'];

        $picture['id'] = $photo_id;
        $picture['name'] = $row['1'];
        $picture['intro'] = $row['2'];
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

        $picture['gender'] = $row['gender'];
        $picture['author_name'] = $row['name'];
        $picture['author_avatar'] = $row['avatar'];

        //获取作者发布的图片数量
        $picture_count_sql = "SELECT COUNT(*) AS num FROM picture WHERE author_id = '$author_id'";
        $result_count = $pdo_connect->query($picture_count_sql);
        $row = $result_count->fetch();
        $picture['author_picture_count'] = $row['num'];

        $result[$index] = $picture;
        $index++;
    }
}

echo json_encode($result);