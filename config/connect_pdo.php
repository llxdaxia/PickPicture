<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/2
 * Time: 17:52
 */

$dsn = "mysql:dbname=pick_picture;host=localhost";;
$user = "Lemon";
$password = "Lemon";

try{
    $pdo_connect_db = new PDO($dsn, $user, $password);
}catch (PDOException $e){
    echo  '数据库连接失败 : '.$e->getMessage();
}