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

class Transaction extends  Controller
{
    public function create(){
        $commodity_id = I('commodity_id');
        $date = getCurrentTime();
        $pay_id = uniqid();

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
        return $result;
    }


    public function accept(){
    }


    public function refused(){
    }



}