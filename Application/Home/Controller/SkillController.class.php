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
        $commodity->browse(2);
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
    }

    /**
     * 点赞并收藏
     */
    public function praise()
    {
    }

    /**
     * 我要接受某一订单
     */
    public function accept()
    {
        senderSMS('18795855867','PS','DARXAN');
    }
}