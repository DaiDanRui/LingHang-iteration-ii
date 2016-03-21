<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/3/21
 * Time: 14:10
 */
namespace Home\Model;

use Think\Model;
class EvaluationModel extends Model{

    protected  $fields =- [
        'evaluation_id',
        'commodity_id',
        'is_payer',
        'transaction_id',
        'evaluation_time',
        'evaluation',
        'valuator_id',
        'valuated_id',
        'score1',
        'score2',
        'score3'
    ];
}
