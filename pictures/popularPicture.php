<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 10:16
 */

include '../config/connect_pdo.php';


$query_sql = "SELECT * FROM picture ORDER BY collection_count*5+watch_count ASC limit 10";
$query_result = $pdo_connect_db->query($query_sql);
$result = $query_result->fetchAll();

echo json_encode($result);