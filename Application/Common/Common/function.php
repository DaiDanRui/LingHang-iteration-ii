<?php

/**
 * Created by PhpStorm.
 * User: darxan
* Date: 2016/4/3
* Time: 21:40
*/


/**
 * @param $tableRows array database data
 * @return array a associate array
 */
function convertCommoditiesToTree($tableRows){
    $tree_value = array();
    foreach ($tableRows as $row){
        $commodity_id = $row['commodity_id'];
        if(key_exists($commodity_id,$tree_value)){
            $temp_row = $tree_value[$commodity_id];
            $urls = $temp_row['url'];
            $urls[] = $row['path'];
        }
        else{
            $tree_value[$commodity_id] = array(
                'imgs' => $row['pic_path'],
                'description' => $row['description'],
                'title' => $row['title'],
                'price' => $row['price'],
                'url' =>   array($row['path']), //'upload/default.jpg',
                'name' => $row['nickname'],
                'time' => getBeforetime($row['release_date']),
                'star_numbers' => $row['star_numbers'],
                'message_numbers' => $row['message_numbers'],
                'id' => $row['commodity_id'],
            );
        }
    }
    return $tree_value;
}

/**
 * 获取上传图片数组，并且移动到默认文件夹，返回图片唯一标识名
 * @return array
 */
function getUploadPicturesAndMove(){
    return array('default.jpg');
}

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
//    dump($response);
//    $responseCode = curl_getinfo($curlConn, CURLINFO_HTTP_CODE);
//    dump($responseCode);
    curl_close($curlConn);
    return $response;
}

define('CURRENT_LOGIN_ID',16545);
define('CURRENT_LOGIN_USERNAME',564512);
define('BROWSE_PAGE_SIZE',10);
define('CURRENT_LOGIN_PHONE',46110);
define('CURRENT_LOGIN_AVATAR',1111);
define('REWARD',1);
define('SKILL',2);
define('DEFAULT_AVATAR','avatar.jpg');


function isLogined(){
    return isset($_SESSION[CURRENT_LOGIN_ID]);
}

/**
 * @return bool|string
 */
function getCurrentTime()
{
    return date('Y-m-d H:i:s',time());
}

/**
 * @param $date string 'Y-m-d H:i:s'
 * @return int 多少天前
 */
function getBeforetime($date){
    $now_time = time();
    $time=strtotime($date);
    return (int)( ($now_time-$time) /3600/24);
}

/**
 * @param $date string 'Y-m-d H:i:s'
 * @return int 多少天后
 */
function getAfterTime($date){
    $now_time = time();
    $time=strtotime($date);
    return (int)( ($now_time-$time) /3600/24);
}
session_start();
$_SESSION[CURRENT_LOGIN_ID] = 1;
$_SESSION[CURRENT_LOGIN_AVATAR] = DEFAULT_AVATAR;
$_SESSION[CURRENT_LOGIN_PHONE] = 18795855867;
$_SESSION[CURRENT_LOGIN_USERNAME] = 'loginername';