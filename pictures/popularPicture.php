<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 10:16
 */

include '../config/connect_pdo.php';

$query_sql = "SELECT * FROM picture ORDER BY collection_count*5+watch_count ASC LIMIT 10";
$query_result = $pdo_connect_db->query($query_sql);
$result_rows = $query_result->fetchAll();

$result = array();
foreach($result_rows as $row){
    
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