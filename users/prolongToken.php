<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/6
 * Time: 14:58
 */

include '../config/token.php';
include '../config/header.php';

$headers = getallheaders();
$old_token = get_token($headers);
$token = new Token();
$token->prolong_user_token($old_token);
