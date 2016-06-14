<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/14
 * Time: 20:31
 */

$current_timestamp = time();
$valid_time = 60 * 60 * 24 + $current_timestamp;

$SecretID = 'AKIDol3hHtHrhSZuDCFSCEr0DQCBoyBDlOEf';
$secretKey = '55jtu8MH5BNHl9gPgDQLTc9NPRpmaiJ1';
$orignal = 'u=973829691&a=1007268&k=AKIDol3hHtHrhSZuDCFSCEr0DQCBoyBDlOEf&e=' . "$valid_time" . '&t=' . "$current_timestamp" . '&r=270494647&f=';
$signStr = base64_encode(hash_hmac('sha1', $orignal, $secretKey, true) . $orignal);

echo $signStr;