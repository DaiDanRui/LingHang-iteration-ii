<?php

/**
 * Created by PhpStorm.
 * User: darxan
* Date: 2016/4/3
* Time: 21:40
*/
/**
 * 具有函数副左右.
 * <br/>图片集合转换为数组‘url’
 * <br/>时间转换
 * @param $urlKey string the key of pictures
 * @param $dateKey string the key of release_date
 * @param $tableRows array 从数据库取出关联数组
 */
function convertCommoditiesForHtml($urlKey,$dateKey,&$tableRows){
    foreach ($tableRows as &$row){
        $url = &$row[$urlKey];
        $time = &$row[$dateKey];
        $time = getBeforetime($time);
        $url = explode(',',$url);
    }
}

/**
 * 具有函数副左右.
 * <br/>时间转换
 * @param $dateKey string the key of release_date
 * @param $tableRows array 从数据库取出关联数组
 */
function convertCommoditiesWithOnePic($dateKey,&$tableRows){
    foreach ($tableRows as &$row){
        $time = &$row[$dateKey];
        $time = getBeforetime($time);
    }
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
 * @return mixed|true on success or false on failure. However, if the CURLOPT_RETURNTRANSFER
 * option is set, it will return the result on success, false on failure.
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
    return sendCURL($headers,$dataJson,$URL);
}

function sendCURL($headers,$dataJson,$URL){
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
//    $responseCode = curl_getinfo($curlConn, CURLINFO_HTTP_CODE);
    curl_close($curlConn);
    return $response;
}

define('CURRENT_LOGIN_ID',256);
define('CURRENT_LOGIN_USERNAME',257);
define('BROWSE_PAGE_SIZE',10);
define('CURRENT_LOGIN_PHONE',258);
define('CURRENT_LOGIN_AVATAR',259);
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
$_SESSION[CURRENT_LOGIN_ID] = 2;
$_SESSION[CURRENT_LOGIN_AVATAR] = DEFAULT_AVATAR;
$_SESSION[CURRENT_LOGIN_PHONE] = 18795855867;
$_SESSION[CURRENT_LOGIN_USERNAME] = 'loginername';