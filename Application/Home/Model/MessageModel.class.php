<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/3/21
 * Time: 14:18
 */
namespace Home\Model;
use Think\Model;

class MessageModel extends Model{
    protected $fields = [
        'message_id',
        'commodity_id',
        'talker_id',
        'time',
        'content'
    ];
}