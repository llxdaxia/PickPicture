<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/1
 * Time: 10:40
 */

include '../config/connect_mysqli.php';
include '../config/request.php';

$number = $_POST['number'];
$password = $_POST['password'];

if (empty ($number) || empty ($password)) {
    header("HTTP/1.1 400 'error' => '参数不能为空'");
    echo '{"error" : "参数错误"}';
    exit ();
}

$login_sql = "select * from user where number = $number and password = $password limit 1";

$query_result = mysqli_query($mysqli_connection,$login_sql);  

$rows = mysqli_fetch_array($query_result);

if ($rows) {
    $result = array(
        'id' => $rows ['id'],
        'number' => $rows ['number'],
        'password' => $rows ['password'],
        'name' => $rows ['name'],
        'avatar' => $rows ['avatar'],
        'gender' => $rows ['gender'],
        'intro' => $rows ['intro'],
        'token' => strtotime($rows['token'])
    );
} else {
    $result = array(
        'error' => "没有此用户"
    );
}

echo json_encode($result);


