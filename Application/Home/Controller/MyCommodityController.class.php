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
        $field = array(
            'commodity.commodity_id as id',
            'publisher_id',
            'title','price',
            'release_date as time',
            'deleted_date as lefttime',
            'star_numbers as save_num',
            'message_numbers as msg_num',
            'description',
            'group_concat(path) as images',
//            'nickname as name',
//            'pic_path as url',
            'star_numbers as save_num','message_numbers as msg_num',
        );;
        $model = new CommodityModel();
        $model->table($table)->field($field)
            ->where('commodity.commodity_id=picture.commodity_id')
            ->where($where)
            ->group('id')
            ->page($page,BROWSE_PAGE_SIZE);
        $rows = $model->select();

        dump($model->getLastSql());
        foreach($rows as &$row){
            $imgs = &$row['images'];
            $time = &$row['time'];
            $lefttime = &$row['lefttime'];
            $imgs = explode(',',$imgs);
            $time = getBeforetime($time);
            $lefttime = getBeforetime($lefttime);
        }
        dump($rows);
        $this->assign('publishes',$rows);
        $this->assign('avatar',$_SESSION[CURRENT_LOGIN_AVATAR]);
        $this->assign('type',$type);
        if(isDesktop()){
            $page = 'personal/des-my-publish';
        }else{
            $page = 'personal/my-publish';
        }
        $this->display($page);
    }


}