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

define('CURRENT_LOGIN_ID',15256);
define('CURRENT_LOGIN_USERNAME',12257);
define('BROWSE_PAGE_SIZE',10);
define('CURRENT_LOGIN_PHONE',12258);
define('CURRENT_LOGIN_AVATAR',12259);
define('REWARD',1);
define('SKILL',2);
define('DEFAULT_AVATAR','avatar.jpg');

define('INCOME','收入');
define('OUTCOME','支出');


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

function getCommodityTypesAssociate($type){
    $accociate = array(
        '其他'=>0,
        '计算机'=>1,
        '音乐'=>2,
        '体育'=>3,
    );
    if(isset($accociate[$type])){
        return $accociate[$type];
    }
    return 0;
}
function getCommodityTypesArray($index){
    $array = array(
        0=>'其他',
        1=>'计算机',
        2=>'音乐',
        3=>'体育',
    );
    if(isset($index)){
        return $array[$index];
    }return $array[0];
}


function isMobile()
{

    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}


session_start();
$_SESSION[CURRENT_LOGIN_ID] = 2;
$_SESSION[CURRENT_LOGIN_AVATAR] = DEFAULT_AVATAR;
$_SESSION[CURRENT_LOGIN_PHONE] = 18795855867;
$_SESSION[CURRENT_LOGIN_USERNAME] = 'login_name';