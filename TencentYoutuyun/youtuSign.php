<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/14
 * Time: 20:31
 */

const AUTH_URL_FORMAT_ERROR = -1;
const AUTH_SECRET_ID_KEY_ERROR = -2;

$expired = time() + 60 * 60 * 24 * 7; //过期时间
$userid = '973829691';

$appid = '1007268';
$secretId = 'AKIDol3hHtHrhSZuDCFSCEr0DQCBoyBDlOEf';
$secretKey = '55jtu8MH5BNHl9gPgDQLTc9NPRpmaiJ1';

if (empty($secretId) || empty($secretKey)) {
    return -2;
}

$now = time();
$rdm = rand();
$plainText = 'a=' . $appid . '&k=' . $secretId . '&e=' . $expired . '&t=' . $now . '&r=' . $rdm . '&u=' . $userid;
$bin = hash_hmac("SHA1", $plainText, $secretKey, true);
$bin = $bin . $plainText;
$sign = base64_encode($bin);

echo $sign;
