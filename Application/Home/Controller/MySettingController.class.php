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
        if(!isLogined()){
            $this->error(PLEASE_LOGIN);
        }
        $page = 'personal/my-main';
        if(isDesktop()){
            $page = 'personal/des-my-main';
        }
        $model = new UserModel();
        $userInformations = $model->findByID($_SESSION[CURRENT_LOGIN_ID]);
        if(!$userInformations){
            $this->error(PLEASE_LOGIN);
        }
        $userInformation = $userInformations[0];
        $this->assign('comment_buyer',$userInformation['good_seller']);
        $this->assign('comment_seller',$userInformation['good_buyer']);
        $this->assign('avatar_url',$userInformation['pic_path']);

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