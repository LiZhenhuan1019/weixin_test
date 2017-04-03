<?php
/**
 * Created by PhpStorm.
 * User: lzh
 * Date: 4/3/17
 * Time: 9:43 PM
 */
require_once 'get_access_token.php';
function get_user_informantion($openid)
{

    $ch = curl_init();
    $access_token = get_access_token();
    curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $json_code = curl_exec($ch);
    curl_close($ch);
    $array = json_decode($json_code,true);
    return $array;
}