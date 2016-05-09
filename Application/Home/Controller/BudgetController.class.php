<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/12
 * Time: 23:33
 */

namespace Home\Controller;


use Home\Model\BudgetModel;
use Home\Model\UserModel;
use Think\Controller;

class BudgetController extends Controller
{
    public function addBudget(){
        $transaction_id = I('transaction_id');
        $tables = array('tbl_transaction'=>'transaction','tbl_commodity'=>'commodity');
        $fields = array('trader_id','publisher_id','transaction.commodity_id','transaction.transaction_id','commodity.course_or_reward');
        $where = array('tbl_transaction.transaction_id'=>$transaction_id);
        $model = new BudgetModel();
        $commodity_info = $model->table($tables)->field($fields)->where($where)->select();
        if(empty($commodity_info)){
            $this->error('该交易不存在！');
        }
        $current_user=$_SESSION[CURRENT_LOGIN_ID];
        $publisher_id = $commodity_info['publisher_id'];
        $trader_id = $commodity_info['trader_id'];
        if($publisher_id!=$current_user||$trader_id!=$current_user){
            $this->error('您没有权限');
        }
        $payer_id = null;
        $holder_id = null;
        if($commodity_info['course_or_reward']==REWARD){
            $payer_id = $publisher_id;
            $holder_id = $trader_id;
        }else{
            $holder_id=$publisher_id;
            $payer_id=$trader_id;
        }
        $budgetArray=array(
            'transaction_id'=>$transaction_id,
            'pay_date'=>getCurrentTime(),
            'commodity_id'=>$commodity_info['commodity_id'],
            'payer_id'=>$payer_id,
            'holder_id'=>$holder_id,
        );
        $result = $model->table('tbl_budget')->add($budgetArray);
        if($result){
            $this->success('');
        }else{
            $this->error('订单生成失败');
        }
    }



    public function outcome(){
        $loginer = $_SESSION[CURRENT_LOGIN_ID];
        $where = " payer_id='$loginer' ".' AND user.user_id=holder_id AND transaction.commodity_id=commodity.commodity_id ';
        $this->_budget($where,1);

//        $this->assign('isIncome',0);
    }

    public function income(){
        $current_user = $_SESSION[CURRENT_LOGIN_ID];
        $where = " holder_id='$current_user'".' AND user.user_id=payer_id AND transaction.commodity_id=commodity.commodity_id ';
         $this->_budget($where,1);

    }


    private function _budget($where,$isIncome){

        $tables = array('tbl_commodity'=> 'commodity','tbl_transaction'=>'transaction','tbl_budget' => 'budget','tbl_user'=> 'user');
        $fields = array(
            'publisher_id',
            'pay_date as time',
            'price',
            'title',
            'commodity.commodity_id',
            'skill_or_reward as type',
            'user.user_id as trader',
            'user.nickname'=>'username',
        );
        $model = new BudgetModel();
        $rows = $model->table($tables)->field($fields)->where($where)->select();

        $model = new UserModel();
        $userInfo = $model->findByID($_SESSION[CURRENT_LOGIN_ID]);
        if(!$userInfo){
            $this->error(PLEASE_LOGIN);
        }
        $userInformation = $userInfo[0];
        $this->assign('username',$userInformation['nickname']);
        $this->assign('income',$userInformation['income']);
        $this->assign('outcome',$userInformation['outcome']);
        $this->assign('avatar_url',$_SESSION[CURRENT_LOGIN_AVATAR]);
        $this->assign('isIncome',$isIncome);
        $this->assign('records',$rows);

        if(isDesktop()){
            $page = ('personal/des-my-account');
        }else{
            $page = ('personal/my-account');
        }
        $this->display($page);
    }



}