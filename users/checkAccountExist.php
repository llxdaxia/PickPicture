<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/6
 * Time: 10:50
 */

include '../config/connect_pdo.php';
include '../config/check.php';

$number = $_POST['number'];

check_empty($number);

$query_sql = "SELECT * FROM user WHERE number = '$number' LIMIT 1";
$query_result = $pdo_connect->query($query_sql);
if($query_result->rowCount()){
    $result['exist'] = "true";
}else{
    $result['exist'] = "false";
}

echo json_encode($result);