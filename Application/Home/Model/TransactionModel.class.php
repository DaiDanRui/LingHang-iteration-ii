<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/3/21
 * Time: 14:24
 */
namespace Home\Model;

use Think\Model;

class TransactionModel extends Model{
    protected $fields = [
      'transaction_id',
        'commodity_id',
        'state',
        'commodity_holder_id',
        'commodity_buyer_id',
        'price',
        'date_choose',
        'last_update',
        'pay_id',
        'skill_or_reward',
    ];
}