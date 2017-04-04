<?php
/**
 * Created by PhpStorm.
 * User: lzh
 * Date: 4/3/17
 * Time: 10:26 PM
 */
require_once 'get_access_token.php';
function get_menu()
{
    $filename = "./buttons.json";
    $file = fopen($filename,'r');
    $json_data = fread($file,filesize($filename));
    return $json_data;
}
function create_menu()
{
    $menu = get_menu();
    $access_token = get_access_token();
    $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$menu);
    curl_exec($ch);
}
function delete_menu()
{
    $access_token = get_access_token();
    $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=$access_token";
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_exec($ch);
}
function update_menu()
{
    delete_menu();
    create_menu();
}

create_menu();
