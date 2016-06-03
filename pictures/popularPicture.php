<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 10:16
 */

$query_sql = "SELECT * FROM picture ORDER BY collection_count*5+watch_count ASC LIMIT 10";
$query_result = $pdo_connect->query($query_sql);
$result_rows = $query_result->fetchAll();

$result = array();
$index = 0;

foreach($result_rows as $row){

    $temp = array();
    $temp['id'] = $row['id'];
    $temp['name'] = $row['name'];
    $temp['intro'] = $row['intro'];
    $temp['width'] = $row['width'];
    $temp['height'] = $row['height'];
    $temp['src'] = $row['src'];
    $temp['author_id'] = $row['author_id'];
    $temp['tag'] = $row['tag'];
    $temp['score'] = $row['score'];
    $temp['watch_count'] = $row['watch_count'];
    $temp['collection_count'] = $row['collection_count'];
    $temp['album_id'] = $row['album_id'];
    $temp['create_time'] = strtotime($row['create_time']);

    $result[$index] = $temp;
    $index ++;
}
echo json_encode($result);