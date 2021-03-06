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
        $this->assign('accepts',$tree_value);
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
        $this->assign('accepts',$tree_value);
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
        $this->assign('accepts',$tree_value);
        if(isDesktop()){
            $page = 'personal/des-my-accept';
        }else{
            $page = 'personal/my-accept';
        }
        $this->display($page);
    }

    /**
     * 接受的悬赏
     */
    public function transactionReward(){
        $tree_value=$this->_transaction(REWARD);
        $this->assign('accepts',$tree_value);
        if(isDesktop()){
            $page = 'personal/des-my-accept';
        }else{
            $page = 'personal/my-accept';
        }
        $this->display($page);
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
        $whereString = $whereString.' and commodity.commodity_id=picture.commodity_id ';
        $field = array(
            'commodity.commodity_id as id',
            'publisher_id',
            'title','price',
            'release_date as time',
            'star_numbers','message_numbers','description',
            'max(path) as commodity_url',
            'nickname as username',
            'pic_path as avatar_url',
        );
        $model = new TransactionModel();
        $model->table($table)->field($field)->page($page,BROWSE_PAGE_SIZE)->where($whereString)->group('id');
        $array = $model->select();

        foreach ($array as &$row){
            $time = &$row['time'];
            $time = getBeforetime($time);
        }
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
        $title = I('title');
        $transaction_information = array(
            'commodity_id'=>$commodity_id,
            'state'=>0,
            'date_choose'=> $date,
            'last_update'=>$date,
            'pay_id'=>$pay_id,
            'trader_id'=>$_SESSION[CURRENT_LOGIN_ID]
        );
        dump($transaction_information);
        $model = new TransactionModel();
        $result = $model->add($transaction_information);
        if($result){
            import('@/Logic/SenderSMS');
            $response = send($phone,$title,$_SESSION[CURRENT_LOGIN_USERNAME],$_SESSION[CURRENT_LOGIN_PHONE]);
            $this->success('sucess with '.$response,U('commodity/skill'),3);
        }else{
            $this->error('wrong');
        }

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