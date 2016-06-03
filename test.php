<?php
include "./config/request.php";
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/2
 * Time: 13:32
 */

$params = array(
    'number' => $number,
    'password' => $password
);

echo request::postRequest("http://localhost/v1/users/login.php",$params);