<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/11
 * Time: 15:27
 */

namespace Home\Controller;



use Home\Model\CommodityModel;
use Think\Controller;

/**
 * 我的被接受的商品
 * Class MyTransaction
 * @package Home\Controller
 */
class MyTransaction extends Controller
{


    /**
     * 被接受的技能
     */
    public function transactionSkill(){
        $tree_value=$this->transaction(SKILL);
        dump($tree_value);
    }

    /**
     * 被接受的悬赏
     */
    public function transactionReward(){
        $tree_value=$this->transaction(REWARD);
        dump($tree_value);
    }

    /**
     * @param $type int SKILL or REWARD 技能或者悬赏
     * @return array
     */
    public function transaction($type){
        $page = (int) I('page');
        $current_loginer = $_SESSION[CURRENT_LOGIN_ID];

        $table = array('tbl_transaction'=>'transaction','tbl_commodity' =>'commodity','tbl_picture' =>'picture' ,'tbl_user' =>'user');
        $field = array(
            'commodity.commodity_id','publisher_id',
            'title','price','release_date',
            'star_numbers','message_numbers',
            'path','nickname','pic_path',
        );
        $where = array(
            'skill_or_reward'=>$type,
            'transaction.trader_id'=>$current_loginer,
        );
        $model = new CommodityModel();
        $model->table($table)->field($field)->page($page,BROWSE_PAGE_SIZE)->where($where)
              ->where('transaction.commodity_id=commodity.commodity_id AND transaction.commodity_id=picture.commodity_id AND commodity.publisher_id=user.user_id');
        $rows = $model->select();

        $array = array();
        foreach ($rows as $temp_database_row_array) {
            $array[] = array(
                'url_header' => $temp_database_row_array['pic_path'],
                'url_pic' =>  $temp_database_row_array['pic_path'],
                'acceptor' => $temp_database_row_array['nickname'],
                'title'=> $temp_database_row_array['title'],
                'price' => $temp_database_row_array['price'],
                'id' => $temp_database_row_array['commodity_id'],
            );
        }
        return $array;
    }
}