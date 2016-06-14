<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 10:16
 */
include '../config/connect_pdo.php';
include '../config/statusCode.php';

$headers = getallheaders();
$UID = $headers['UID'];  //可能登陆，也可以能没有登陆

$query_sql = "SELECT * FROM picture INNER JOIN user ON picture.author_id = user.id ORDER BY collection_count*5+watch_count DESC LIMIT 10";
$query_result = $pdo_connect->query($query_sql);

$result = array();
if ($query_result->rowCount()) {
    $result_rows = $query_result->fetchAll();

    $index = 0;

    foreach ($result_rows as $row) {

        $photo_id = $row['0'];   //图片id
        $author_id = $row['author_id'];   //作者id

        //是否被收藏
        if (!empty($UID)) {
            $collection_sql = "SELECT * FROM picture_collection WHERE user_id = '$UID' AND photo_id = '$photo_id' LIMIT 1";
            $result_is_collection = $pdo_connect->query($collection_sql);
            $temp['is_collection'] = $result_is_collection->rowCount() > 0;
        }

        $temp['id'] = $photo_id;
        $temp['name'] = $row['1'];
        $temp['gender'] = $row['gender'];
        $temp['intro'] = $row['intro'];
        $temp['width'] = $row['width'];
        $temp['height'] = $row['height'];
        $temp['src'] = $row['src'];
        $temp['author_id'] = $author_id;
        $temp['tag'] = $row['tag'];
        $temp['score'] = $row['score'];
        $temp['watch_count'] = $row['watch_count'];
        $temp['collection_count'] = $row['collection_count'];
        $temp['album_id'] = $row['album_id'];
        $temp['create_time'] = strtotime($row['create_time']);

        $temp['author_name'] = $row['16'];
        $temp['author_avatar'] = $row['17'];

        //获取作者发布的图片数量
        $picture_count_sql = "SELECT COUNT(*) AS num FROM picture WHERE author_id = '$author_id'";
        $result_count = $pdo_connect->query($picture_count_sql);
        $row = $result_count->fetch();
        $temp['author_picture_count'] = $row['num'];

        $result[$index] = $temp;
        $index++;
    }
} else {
    serverError();
}


echo json_encode($result);