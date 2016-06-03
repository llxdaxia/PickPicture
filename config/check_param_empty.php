<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 16:01
 */

function check_empty(){

    $args = func_get_args();

    for ($i = 0 ;$i < count($args) ;$i++){
        if($args[$i] == ""){
            header("http/1.1 400 Bad Request");
            $result["error"] = "参数不能为空";
            echo json_encode($result);
            exit();
        }
    }
}