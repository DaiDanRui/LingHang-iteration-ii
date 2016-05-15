<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/5/7
 * Time: 9:27
 */
use Think\Upload;

/**
 * 获取上传图片数组，并且移动到默认文件夹，返回图片唯一标识名
 * @return array
 */
function getUploadPicturesAndMove(){

    $upload = new Upload();// 实例化上传类
    $upload->maxSize  = 3145728 ;// 设置附件上传大小
    $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath = './Public/picture/';
    $upload->savePath =  '';// 设置附件上传目录

    $info = $upload->upload();
    if ($info){
        return $info;
    }else{
        return array(
            array(
                'savepath'=>'','savename'=>DEFUALT_PIC
            )
        );
    }
}
