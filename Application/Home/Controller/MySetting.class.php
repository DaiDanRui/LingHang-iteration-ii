<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/11
 * Time: 15:09
 */

namespace Home\Controller;


use Think\Controller;

class MySetting extends  Controller
{
    /**
     * 点击”我的“后进入界面。
     */
    public function myPage(){
        $this->display('');
    }

    /**
     * 进入”我的“后，点击设置
     */
    public function setPage(){
        $this->display('');
    }


    public function accountSetPage(){
        $this->display('');
    }


    public function topic(){
        $this->display('');
    }

    public function aboutusPage(){
        $this->display('');
    }
}