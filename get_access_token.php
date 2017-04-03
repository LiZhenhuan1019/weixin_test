<?php
/**
 * Created by PhpStorm.
 * User: lzh
 * Date: 4/3/17
 * Time: 3:33 PM
 */
define("appID", "wx343420ed7095b24b");
define("appsecret", "6e94dc427649af72d39e0a9a36083139");

function update_access_token()
{
    $ch = curl_init();
    $appID = appID;
    $appsecret = appsecret;
    curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appID&secret=$appsecret");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $json_code = curl_exec($ch);
    curl_close($ch);
    $array = json_decode($json_code,true);
    return $array;
}

function get_access_token()
{
    $memcache = new Memcache();
    $memcache->connect("115.159.34.136", 11211) or die("Could not connect with memcached");
    $access_token = $memcache->get('access_token');
    if ($access_token === false) {
        $result = update_access_token();
        if (key_exists('access_token', $result)) {
            $access_token = $result['access_token'];
            $inspired_second = $result['expires_in'];
            $memcache->set('access_token',$access_token,false,$inspired_second - 30);
        } else
            throw $result;
    }
    return $access_token;
}

print_r(get_access_token());