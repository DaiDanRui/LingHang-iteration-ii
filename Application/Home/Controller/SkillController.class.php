<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/3/22
 * Time: 22:46
 */

namespace Home\Controller;


use Think\Controller;

class SkillController extends Controller
{


    /**
     * 浏览商品模式
     */
    public function browse()
    {
        $commodity = new CommodityController();
        $array = $commodity->browse(SKILL);
        $this->assign('commodities',$array);
        $this->assign('currentUsername',$_SESSION[CURRENT_LOGIN_USERNAME]);
        $this->assign('currentUserPhone',$_SESSION[CURRENT_LOGIN_PHONE]);
        $this->assign('type',SKILL);
        $this->display('main/market-main');


    }



    /**
     * 详细查看某一个具体悬赏或者技能
     * 包括商品信息，留言信息
     */
    public function details()
    {
        $commodity = new CommodityController();
        $message = $commodity->details();
        foreach($message as $key=>$value ) {
            $this->assign($key,$value);
        }
        $this->display('main/market-skill');

    }

    /**
     * 点赞并收藏
     */
    public function praise()
    {
    }


}