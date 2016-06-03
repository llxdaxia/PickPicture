<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/1
 * Time: 10:41
 */
session_start();
header("Content-Type: text/html; charset=utf-8") ;

$server_name = "localhost";
$username = "Lemon";
$password = "Lemon";
$database_name = "pick_picture";

// 创建连接
$mysqli_connection = new mysqli($server_name, $username, $password,$database_name);
mysqli_query($mysqli_connection,"set names utf8");

// 检测连接
if ($mysqli_connection->connect_error) {
    die("Connection failed: " . $mysqli_connection->connect_error);
}