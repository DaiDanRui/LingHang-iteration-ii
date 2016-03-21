<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/3/21
 * Time: 10:40
 */

namespace Home\Model;


use Think\Model;

class CommodityModel extends Model
{
    protected  $fields = [
        'commodity_id',
        'skill_or_reward',
        'type',
        'publisher_id',
        'price',

        'release_date',
        'deleted_date',

        'title',
        'description',

        'commodity_state',
        'star_numbers',
        'message_numbers'
    ];
}