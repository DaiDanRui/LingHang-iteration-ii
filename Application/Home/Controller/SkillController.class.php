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
//        $commodity = new CommodityController();
//        $array = $commodity->browse(SKILL);
//        $this->assign('array',$array);
        $this->display('main/market-main');


    }

    /**
     * 上传
     */
    public function upload()
    {

    }

    /**
     * 详细查看某一个具体悬赏或者技能
     * 包括商品信息，留言信息
     */
    public function details()
    {
        $commodity = new CommodityController();
        $commodity->details();
    }

    /**
     * 点赞并收藏
     */
    public function praise()
    {
    }


}