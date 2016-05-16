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




define('CURRENT_LOGIN_ID','id');
define('CURRENT_LOGIN_USERNAME','name');
define('BROWSE_PAGE_SIZE','page_size');
define('CURRENT_LOGIN_PHONE','phone_number');
define('CURRENT_LOGIN_AVATAR','avatar');
define('REWARD',1);
define('SKILL',2);
define('DEFAULT_AVATAR','avatar.jpg');
define('DEFUALT_PIC','pic.jpg');

define('INCOME','收入');
define('OUTCOME','支出');

define('PLEASE_LOGIN','请先登录');

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

function isDesktop(){
    return false;
}


//$_SESSION[CURRENT_LOGIN_ID] = 3;
//$_SESSION[CURRENT_LOGIN_AVATAR] = DEFAULT_AVATAR;
//$_SESSION[CURRENT_LOGIN_PHONE] = 18795855867;
//$_SESSION[CURRENT_LOGIN_USERNAME] = 'dai';