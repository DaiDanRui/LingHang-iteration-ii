<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/3/21
 * Time: 14:22
 */
namespace Home\Model;

use Think\Model;

class PraiseModel extends Model{
    protected $fields = array(
        'commodity_id',
        'praiser_id',  //unique praiser_id , commodity_id
    );
}