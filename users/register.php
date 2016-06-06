<?php

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/request.php';
include '../config/config.php';

// 配置项

$name = $_REQUEST['name'];
$password = $_REQUEST['password'];
$code = $_REQUEST['code'];
$number = $_REQUEST['number'];
$avatar = $_REQUEST['avatar'];

check_empty($name, $password, $code, $number);
check_has_exist($pdo_connect, "user", "number", $number);

if ($avatar == "") {
    $avatar = Config::$DEFAULT_AVATAR;
}

$response = postRequest(Config::$API_MOB_VERIFY_CODE, array(
    'appkey' => Config::$MOB_APP_KEY,
    'phone' => $number,
    'zone' => '86',
    'code' => $code,
));

$response_json = json_decode($response, true);

if ($response_json['status'] == 200) {

    check_has_exist($pdo_connect, "user", "name", $name);

    $token = new Token();
    $real_token_str = $token->get_token($name, "pick_picture"); //生成token

    $insert_sql = "insert into user (name,password,number,avatar,token) 
values('$name','$password','$number','$avatar','$real_token_str')";
    $insert_user = $pdo_connect->exec($insert_sql);

    if ($insert_user) {
        $result['info'] = "success";
    } else {
        $result['info'] = "failed";
    }
} else if ($response_json['status'] == 468) {
    header("http/1.1 400 Bad Request");
    $result["error"] = "验证码错误";
} else {
    header("http/1.1 400 Bad Request");
    $result["error"] = "验证平台" . $response;
}

echo json_encode($result);
