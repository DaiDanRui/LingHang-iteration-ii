<?php

/**
 * Created by PhpStorm.
 * User: darxan
* Date: 2016/4/3
* Time: 21:40
*/

/**
 * *
 * unify	尊敬的用户您好，您发布的技能/悬赏
 * {{title}}已被客户 {{username}}选中。请前
 * 往领行客户中心查看详情并与客户{{phone}}联系。
 * @param $target_phone string 通知对象
 * @param $title string   对应技能或悬赏名
 * @param $username string 请求人用户名
 * @param $phone string 联系电话
 */
function senderSMS($target_phone, $title, $username, $phone)
{
    $headers = array(
        'Content-Type: application/json',
        'X-LC-Id: yaY0plwRCXkC1fj95Wpb0qMr-gzGzoHsz',
        'X-LC-Key: hEWBidWo48673Jd9AKBGW3Vl',

    );
    $dataJson = json_encode(
        array(
            'title'=>$title,
            'mobilePhoneNumber'=>$target_phone,
            'phone'=>$phone,
            'username'=>$username,
            'template'=>'unify',
        )
    );
    $URL = 'https://api.leancloud.cn/1.1/requestSmsCode';

    $curlConn = curl_init();


    curl_setopt($curlConn, CURLOPT_TIMEOUT, 30);
    curl_setopt($curlConn, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curlConn, CURLOPT_USERAGENT, 'https://api.leancloud.cn/1.1/requestSmsCode');
    curl_setopt($curlConn, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlConn, CURLINFO_HEADER_OUT, true);
    curl_setopt($curlConn, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($curlConn, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curlConn, CURLOPT_POSTFIELDS, $dataJson);
    curl_setopt($curlConn, CURLOPT_URL, $URL);

    $response = curl_exec($curlConn);
    dump($response);
    $responseCode = curl_getinfo($curlConn, CURLINFO_HTTP_CODE);
    dump($responseCode);

    curl_close($curlConn);
}


function getCurrentTime()
{
    return date('Y-m-d H:i:s',time());
}


function get_time($time){
    return $time;
}