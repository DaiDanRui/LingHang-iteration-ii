<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/11
 * Time: 15:09
 */

namespace Home\Controller;


use Home\Model\UserModel;
use Think\Controller;

class MySettingController extends  Controller
{
    /**
     * 点击”我的“后进入界面。
     */
    public function myPage(){
        $page = 'personal/my-main';
        if(isDesktop()){
            $page = 'personal/des-my-main';
        }
        $model = new UserModel();
//        $model->f
        $this->display($page);
    }

    /**
     * 进入”我的“后，点击设置
     */
    public function setPage(){
        $this->display('personal/my-set');
    }


    public function accountSetPage(){
        $this->display('personal/my-account-set');
    }


    public function topic(){
        $this->display('');
    }

    public function aboutusPage(){
        $this->display('');
    }
}