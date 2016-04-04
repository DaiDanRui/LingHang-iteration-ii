<?php
namespace Home\Model;
use Think\Model;

/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/3/21
 * Time: 10:31
 */
class BudgetModel extends Model
{

    protected  $fields = array(
        'budget_id',
        'transaction_id',
        'pay_date',
        'commodity_id',
        'payer_id',
        'holder_id'
    );


}