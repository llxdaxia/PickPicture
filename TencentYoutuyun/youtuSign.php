<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/14
 * Time: 20:31
 */

namespace TencentYoutuyun;

$expired = time() + 2592000;

$secretId = 'AKIDol3hHtHrhSZuDCFSCEr0DQCBoyBDlOEf';
$secretKey = '55jtu8MH5BNHl9gPgDQLTc9NPRpmaiJ1';
$appid = '1007268';
if (empty($secretId) || empty($secretKey)) {
    return -2;
}

$now = time();
$rdm = rand();
$plainText = 'a=' . $appid . '&k=' . $secretId . '&e=' . $expired . '&t=' . $now . '&r=' . $rdm . '&u=' . $userid;
$bin = hash_hmac("SHA1", $plainText, $secretKey, true);
$bin = $bin . $plainText;
$sign = base64_encode($bin);

$result['token'] = $sign;
echo json_encode($result);
