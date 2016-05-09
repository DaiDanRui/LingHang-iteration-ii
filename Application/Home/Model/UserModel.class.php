<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/3/21
 * Time: 14:28
 */
namespace Home\Model;

use Think\Model;

class UserModel extends Model{
    protected $fields = array(
      'user_id',
        'is_seller',

        'nickname',
        'password',
        'username',
        'school',
        'school_id',
        'phone',
        'email',
        'birth',

        'account_state',
        'create_time',
        'last_log',
        'gender',
        'good_seller',
        'good_buyer',
        'pic_path',
        'income',
        'outcome',

        'good_at',
        'hobby',
        'introduction',

    );

    /**
     * @param $id
     */
    function findByID($id){
        $where = array('user_id'=>$id);
        return $this->where($where)->select();
    }
}