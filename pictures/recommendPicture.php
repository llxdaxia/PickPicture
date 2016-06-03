<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 13:00
 */

include '../config/connect_pdo.php';
include '../config/check.php';

$page = $_REQUEST['page'];

check_empty($page);

$start = ($page - 1) * 20;
$end = $page * 20;

$query_sql = "SELECT * FROM picture LIMIT $start,$end";
$query_result = $pdo_connect->query($query_sql);

//echo $pdo_connect_db->errorCode();
//echo $pdo_connect_db->errorInfo();

$result_rows = $query_result->fetchAll();
$result = array();

foreach ($result_rows as $row) {
    $result['id'] = $row['id'];
    $result['name'] = $row['name'];
    $result['intro'] = $row['intro'];
    $result['width'] = $row['width'];
    $result['height'] = $row['height'];
    $result['src'] = $row['src'];
    $result['author_id'] = $row['author_id'];
    $result['tag'] = $row['tag'];
    $result['score'] = $row['score'];
    $result['watch_count'] = $row['watch_count'];
    $result['collection_count'] = $row['collection_count'];
    $result['album_id'] = $row['album_id'];
    $result['create_time'] = strtotime($row['create_time']);
}

echo json_encode($result);