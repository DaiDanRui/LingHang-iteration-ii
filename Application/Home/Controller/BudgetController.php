<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/12
 * Time: 23:33
 */

namespace Home\Controller;


use Home\Model\BudgetModel;
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



    public function budgetPay(){
        $loginer = $_SESSION[CURRENT_LOGIN_ID];
        $where = " payer_id='$loginer' ".' AND user.user_id=holder_id AND transaction.commodity_id=commodity.commodity_id ';
        $ret = $this->_budget($where);
        $this->_converBudgetForHtml($ret,OUTCOME);
    }

    public function budgetIncome(){
        $current_userr = $_SESSION[CURRENT_LOGIN_ID];
        $where = " holder_id='$current_userr''".' AND user.user_id=payer_id AND transaction.commodity_id=commodity.commodity_id ';
        $ret = $this->_budget($where);
        $this->_converBudgetForHtml($ret,INCOME);
    }


    private function _budget($where){

        $tables = array('tbl_commodity commodity','tbl_budget budget','tbl_user user');
        $fields = array(
            'publisher_id',
            'pay_date as time',
            'price',
            'title',
            'commodity.commodity_id',
            'course_or_reward as type',
            'user_id as trader'
        );
        $model = new BudgetModel();
        $retarray = $model->table($tables)->field($fields)->where($where)->select();
        return $retarray;
    }

    /**
     * @param $array
     * @param $income_or_outcome string
     * @return array
     */
    private function _converBudgetForHtml(&$array, $income_or_outcome){
        foreach ($array as &$temp_account_ary) {
            $course_or_reward = $temp_account_ary['type']==REWARD? '悬赏':'技能';
            $account_ary[] = array(
                'type' => $course_or_reward,
                'price_type' =>$income_or_outcome,
            );
        }
    }
}