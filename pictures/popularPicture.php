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
$UID = $headers['UID'];

$query_sql = "SELECT * FROM picture ORDER BY collection_count*5+watch_count ASC LIMIT 10";
$query_result = $pdo_connect->query($query_sql);

$result = array();
if ($query_result->rowCount()) {
    $result_rows = $query_result->fetchAll();

    $index = 0;

    foreach ($result_rows as $row) {

        $photo_id = $row['id'];
        $author_id = $row['author_id'];

        $collection_sql = "SELECT * FROM picture_collection WHERE user_id = '$id' AND photo_id = '$photo_id' LIMIT 1";
        $result_is_collection = $pdo_connect->query($collection_sql);

        $temp['id'] = $row['id'];
        $temp['name'] = $row['name'];
        $picture['gender'] = $row['gender'];
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
        if (!empty($UID)) {
            $temp['is_collection'] = $result_is_collection->rowCount() > 0;
        }

        //获取作者的头像和昵称
        $avatar_sql = "SELECT * FROM user WHERE id = '$author_id' LIMIT 1";
        $result_avatar = $pdo_connect->query($avatar_sql);
        $author = $result_avatar->fetch();

        $temp['author_avatar'] = $author['avatar'];
        $temp['author_name'] = $author['name'];

        //获取作者发布的图片数量
        $picture_count_sql = "SELECT * FROM picture WHERE author_id = '$author_id'";
        $result_count = $pdo_connect->query($picture_count_sql);
        $result_count->fetchAll();
        $temp['author_picture_count'] = $result_count->rowCount();;

        $result[$index] = $temp;
        $index++;
    }
} else {
    serverError();
}


echo json_encode($result);