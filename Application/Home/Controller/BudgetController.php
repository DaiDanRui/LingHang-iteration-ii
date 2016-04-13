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

    }



    public function budgetPay(){
        $loginer = $_SESSION[CURRENT_LOGIN_ID];
        $tables = array('tbl_commodity commodity','tbl_budget budget','tbl_user user');
        $fields = array('publisher_id','payer_id','holder_id','pay_date','prrice','title','commodity.commodity_id','course_or_reward','user_id');
        $where = " payer_id='$loginer' ".' AND user.user_id=holder_id AND transaction.commodity_id=commodity.commodity_id ';
        $model = new BudgetModel();
        $retarray = $model->table($tables)->field($fields)->where($where)->select();
        $arrayForHtml = $this->_converBudgetForHtml($retarray,'付款');
        dump($arrayForHtml);
    }

    public function budgetIncome(){
        $loginer = $_SESSION[CURRENT_LOGIN_ID];
        $tables = array('tbl_commodity commodity','tbl_budget budget','tbl_user user');
        $fields = array('publisher_id','payer_id','holder_id','pay_date','prrice','title','commodity.commodity_id','course_or_reward','user_id');
        $where = " holder_id='$loginer''".' AND user.user_id=payer_id AND transaction.commodity_id=commodity.commodity_id ';
        $model = new BudgetModel();
        $retarray = $model->table($tables)->field($fields)->where($where)->select();
        $arrayForHtml = $this->_converBudgetForHtml($retarray,'收款');
        dump($arrayForHtml);
    }

    /**
     * @param $array
     * @param $income_or_outcome string
     * @return array
     */
    private function _converBudgetForHtml($array, $income_or_outcome){
        $account_ary = array();
        foreach ($array as $temp_account_ary) {
            $course_or_reward = $temp_account_ary['course_or_reward']==REWARD? '悬赏':'技能';
            $account_ary[] = array(
                'time' => $temp_account_ary['pay_date'],
                'type' => $course_or_reward,
                'title' => $temp_account_ary['title'],
                'trader' => $temp_account_ary['user_id'],
                'price' => $temp_account_ary['price'],
                'price_type' =>$income_or_outcome,
            );
        }
        return $account_ary;
    }
}