<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/5/7
 * Time: 9:27
 */

/**
 * 获取上传图片数组，并且移动到默认文件夹，返回图片唯一标识名
 * @return array
 */
function getUploadPicturesAndMove(){

    import('@.Net.UploadFile');
    $upload = new UploadFile();// 实例化上传类
    $upload->maxSize  = 3145728 ;// 设置附件上传大小
    $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath = './Public/';
    $upload->savePath =  'Uploads/';// 设置附件上传目录
//    import("@.ORG.Image");
//    $upload->thumb = true;
//    $upload->thumbMaxWidth = '50,200';
//    $upload->thumbMaxHeight = '50,200';
    //设置上传文件规则
    $upload->saveRule = 'uniqid';
    //删除原图
//    $upload->thumbRemoveOrigin = true;

    if (!$upload->upload()) {
        return false;
    } else {
        $uploadList = $upload->getUploadFileInfo();


    }

    return array('default.jpg');
}
