<?php
/**
 * Created by PhpStorm.
 * User: lzh
 * Date: 4/3/17
 * Time: 11:45 PM
 */
require_once 'get_access_token.php';

function update_jsapi_ticket()
{
    $ch = curl_init();
    $access_token = get_access_token();
    curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$access_token&type=jsapi");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $json_code = curl_exec($ch);
    curl_close($ch);
    $array = json_decode($json_code, true);
    if ($array['errcode'] != 0) {
        $array = array('info' => 'fail to update jsapi_ticket') + $array;
        throw $array;
    }
    return $array;
}

function get_jsapi_ticket()
{
    global $memcache;
    $jsapi_ticket = $memcache->get('jsapi_ticket');
    if ($jsapi_ticket === false) {
        $result = update_jsapi_ticket();
        if(key_exists('ticket',$result))
        {
            $jsapi_ticket = $result['ticket'];
            $inspired_second = $result['expires_in'];
            $memcache->set('jsapi_ticket', $jsapi_ticket, false, $inspired_second - 30);
        }
        else
            throw $result;
    }
    return $jsapi_ticket;
}
function get_self_url()
{
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $url;
}
function get_random_string()
{
    return 'afdWQ79elio789REO97sd32Pom39sdfcxwa';
}
function get_config_info()
{
    $noncestr = get_random_string();
    $jsapi_ticket = get_jsapi_ticket();
    $timestamp = time();
    $url = get_self_url();

    $string1 = 'jsapi_ticket=' . $jsapi_ticket . '&noncestr=' . $noncestr . '&timestamp=' . $timestamp .
        '&url=' . $url;
    $signature = sha1($string1);
    return array($timestamp,$noncestr,$signature,$url);
}