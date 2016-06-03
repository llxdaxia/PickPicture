<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 19:15
 * @param $headers
 * @return mixed
 */

function get_UID($headers)
{
    if ($headers['UID'] != "") {
        return $headers['UID'];
    } else {
        $result['info'] = "UID is empty";
        echo json_encode($result);
        exit();
    }

}

function get_token($headers)
{
    if ($headers['token'] != "") {
        return $headers['token'];
    } else {
        $result['info'] = "token is empty";
        echo json_encode($result);
        exit();
    }

}