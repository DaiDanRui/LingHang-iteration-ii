<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/3/21
 * Time: 14:20
 */
namespace Home\Model;

use Think\Model;

class PictureModel extends Model{
    protected  $fields = array(
        'picture_id',
        'commodity_id',
        'path'
    );
}