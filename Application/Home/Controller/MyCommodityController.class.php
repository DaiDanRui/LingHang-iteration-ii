<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/12
 * Time: 13:28
 */

namespace Home\Controller;


use Home\Model\CommodityModel;
use Think\Controller;

/***
 * 我发布的技能与悬赏
 * Class MyCommodity
 * @package Home\Controller
 */
class MyCommodityController extends Controller
{
    /**
     * 我发布的技能
     */
    public function  publishSkill(){
        $this->publish(SKILL);
    }

    /**
     * 我发布的悬赏
     */
    public function publishReward(){
        $this->publish(REWARD);
    }

    /**
     * @param $type int REWARD or SKILL 技能或者悬赏
     * @return array
     */
    public function publish($type){

        $page = (int) I('page');
        $current_user = $_SESSION[CURRENT_LOGIN_ID];
        $table = array('tbl_commodity' =>'commodity','tbl_picture' =>'picture');

        $where = array(
            'commodity.skill_or_reward'=>$type,
            'commodity.publisher_id'=>$current_user,
        );
        $field = CHOOSE_FIELDS;
        $model = new CommodityModel();
        $model->table($table)->field($field)->where($where)->page($page,BROWSE_PAGE_SIZE)
            ->where('commodity.commodity_id=picture.commodity_id');
        $rows = $model->select();
        $imgs = &$rows['imgs'];
        $time = &$rows['time'];
        $imgs = explode(',',$imgs);
        $time = getBeforetime($time);
        dump($rows);
        return $rows;
    }


}