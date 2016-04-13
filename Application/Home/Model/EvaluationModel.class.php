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

    protected  $fields = array(
        'evaluation_id',
//        'commodity_id',
//        'is_payer',   //deleted
        'transaction_id',
        'evaluation_time',
        'evaluation',
//        'valuator_id',
//        'valuated_id',
        'evaluator_id',  //new add
        'evaluated_id',
        'score1',
        'score2',
        'score3'
    );
}
