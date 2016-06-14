<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/6
 * Time: 10:26
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/statusCode.php';
include '../config/request.php';
include '../config/token.php';
include '../config/config.php';

$number = $_POST['number'];
$password = $_POST['password'];
$code = $_POST['code'];

check_empty($number, $password, $code);

$response = postRequest(Config::$API_MOB_VERIFY_CODE, array(
    'appkey' => Config::$MOB_APP_KEY,
    'phone' => $number,
    'zone' => '86',
    'code' => $code,
));

$response_json = json_decode($response, true);

if ($response_json['status'] == 200) {

    $query_sql = "UPDATE user SET number = '$number',password = '$password' WHERE id = '$UID'";
    $query_result = $pdo_connect->query($query_sql);

    if (empty($query_result)) {
        serverError();
    } else {
        $result['info'] = "success";
    }

} else if ($response_json['status'] == 468) {
    header("http/1.1 400 Verification code error");
    $result["error"] = "验证码错误";
} else {
    header("http/1.1 400 Bad Request");
    $result["error"] = "验证平台" . $response;
}

echo json_encode($result);