<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/9
 * Time: 19:08
 */

namespace Home\Controller;


use Home\Model\TransactionModel;
use Think\Controller;

class TransactionController extends  Controller
{

    /**
     * 接受的技能
     */
    public function transactionAcceptedSkill(){
        $tree_value=$this->_transactionAccepted(SKILL);
        $this->assign('commodity',$tree_value);
        if(isDesktop()){
            $page = 'personal/des-my-accepted';
        }else{
            $page = 'personal/my-accepted';
        }
        $this->display($page);
    }

    /**
     * 接受的悬赏
     */
    public function transactionAcceptedReward(){
        $tree_value=$this->_transactionAccepted(REWARD);
        $this->assign('commodity',$tree_value);
        if(isDesktop()){
            $page = 'personal/des-my-accepted';
        }else{
            $page = 'personal/my-accepted';
        }
        $this->display($page);
    }

    private function _transactionAccepted($type){
        $current_loginer = $_SESSION[CURRENT_LOGIN_ID];
        $where=("commodity.publisher_id='$current_loginer' AND skill_or_reward='$type'"
            .' AND commodity.commodity_id=transaction.commodity_id AND commodity.commodity_id=picture.commodity_id AND transaction.trader_id=user.user_id');
        return $this->_searchTransaction($where);
    }


    /**
     * 接受的技能
     */
    public function transactionSkill(){
        $tree_value=$this->_transaction(SKILL);
        $this->assign('commodity',$tree_value);

    }

    /**
     * 接受的悬赏
     */
    public function transactionReward(){
        $tree_value=$this->_transaction(REWARD);
        $this->assign('commodity',$tree_value);

    }

    /**
     * @param $type int SKILL or REWARD 技能或者悬赏
     * @return array
     */
    private function _transaction($type){
        $current_loginer = $_SESSION[CURRENT_LOGIN_ID];
        $where=("transaction.trader_id='$current_loginer' AND skill_or_reward='$type'".
            ' AND transaction.commodity_id=commodity.commodity_id AND transaction.commodity_id=picture.commodity_id AND commodity.publisher_id=user.user_id');
        return $this->_searchTransaction($where);
    }


    private function _searchTransaction($whereString){
        $page = (int) I('page');
        $table = array(
            'tbl_transaction'=>'transaction',
            'tbl_commodity' =>'commodity',
            'tbl_picture' =>'picture' ,
            'tbl_user' =>'user'
        );
        $field = array(
            'commodity.commodity_id as id',
            'publisher_id',
            'title','price',
            'release_date as time',
            'star_numbers','message_numbers','description',
            'group_concat(path) as url_pic',
            'nickname as acceptor',
            'pic_path as url_header',
        );
        $model = new TransactionModel();
        $model->table($table)->field($field)->page($page,BROWSE_PAGE_SIZE)->where($whereString);
        $array = $model->select();
        convertCommoditiesForHtml('url_pic','time',$array);
        return $array;
    }


    /**
     * 有人提请发布信息
     */
    public function create(){
        $commodity_id = I('id');
        $date = getCurrentTime();
        $pay_id = uniqid();
        $phone = i('phone');
        $transaction_information = array(
            'commodity_id'=>$commodity_id,
            'state'=>0,
            'date_choose'=> $date,
            'last_update'=>$date,
            'pay_id'=>$pay_id,
            'trader_id'=>$_SESSION[CURRENT_LOGIN_ID]
        );
        $model = new TransactionModel();
        $result = $model->add($transaction_information);
        dump($result);
    }

    /**
     * 发布者接受
     */
    public function accept(){
    }

    /**
     * 发布者拒绝
     */
    public function refused(){
    }



}