<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/12
 * Time: 22:37
 */

namespace Home\Controller;


use Home\Model\PraiseModel;
use Think\Controller;

/**
 * 赞与收藏
 * Class StarController
 * @package Home\Controller
 */
class StarController extends  Controller
{
    /**
     * 赞 收藏
     */
    public function add(){
        if(!isLogined()){
            $this->success('请先登录','login/login');
            exit;
        }
        $commodity_id = I('commodity_id');
        $user_id = $_SESSION[CURRENT_LOGIN_ID];
        $star= array('commodity_id'=>$commodity_id,'praiser_id'=>$user_id);
        $model = new PraiseModel();
        $selectResult = $model->where($star)->select();
        if(empty($selectResult)){
            $model->add($star);
            $result =  $model->add($star);
            if(!$result){
                $this->error('add failed');
            }else{
                $where = array('commodity_id'=>$commodity_id);
                $result = $model->table('tbl_commodity')->where($where)->setInc('praise',1);
                dump($result);
            }
        }

    }

    public function myStarSkill(){
        $this->_myStars(SKILL);
    }
    public function myStarReward(){
        $this->_myStars(REWARD);
    }
    /**
     * 我赞过的
     * 我收藏的
     */
    private function _myStars($type){
        $page = (int) I('page');
        $current_loginer = $_SESSION[CURRENT_LOGIN_ID];
        $table = array('tbl_commodity' =>'commodity','tbl_picture' =>'picture','tbl_praise'=>'praise','tbl_user'=>'user');
        $field = array(
            'commodity.commodity_id as id',
            'publisher_id',
            'title','price',
            'release_date as publish_time',
            'star_numbers as save_num',
            'message_numbers as msg_num',
            'description',
            'group_concat(path) as images',
            'nickname as username',
            'pic_path as avatar_url',
        );
        $model = new PraiseModel();

        $where = 'praise.praiser_id='."'$current_loginer'".' AND commodity.skill_or_reward='."'$type'"
                . 'AND praise.commodity_id=commodity.commodity_id'
                .' AND praise.commodity_id=picture.commodity_id'
                .' AND commodity.publisher_id=user.user_id';
        $model->table($table)->field($field)->where($where)->page($page,BROWSE_PAGE_SIZE)->group('id');
        $result = $model->select();

        convertCommoditiesForHtml('images','publish_time',$result);
        if(isDesktop()){
            $page = 'personal/des-my-star';
        }else{
            $page = 'personal/my-star';
        }
        $this->assign('stars',$result);
        $this->display($page);
    }


}