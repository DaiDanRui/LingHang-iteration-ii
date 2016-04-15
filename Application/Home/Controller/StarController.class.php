<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/12
 * Time: 22:37
 */

namespace Home\Controller;


use Home\Model\PraiseModel;
use Think\Controller;

/**
 * 赞与收藏
 * Class StarController
 * @package Home\Controller
 */
class StarController extends  Controller
{
    /**
     * 赞 收藏
     */
    public function add(){
        $commodity_id = I('commodity_id');
        $user_id = $_SESSION[CURRENT_LOGIN_ID];
        $star= array('commodity_id'=>$commodity_id,'praiser_id'=>$user_id);
        $model = new PraiseModel();
        $selectResult = $model->where($star)->select();
        if(empty($selectResult)){
            $model->add($star);
        }
    }

    /**
     * 我赞过的
     * 我收藏的
     */
    public function myStars(){
        $page = (int) I('page');
        $current_loginer = $_SESSION[CURRENT_LOGIN_ID];
        $table = array('tbl_commodity' =>'commodity','tbl_picture' =>'picture','tbl_praise'=>'praise');
        $field = array(
            'commodity.commodity_id as id',
            'publisher_id',
            'title','price',
            'release_date as time',
            'star_numbers','message_numbers','description',
            'group_concat(path) as url',
            'nickname as name',
            'pic_path as imgs',
        );
        $model = new PraiseModel();
        $where = 'praise.praiser_id='."'$current_loginer'"
                . 'AND praise.commodity_id=commodity.commodity_id AND praise.commodity_id=picture.commodity_id';
        $model->table($table)->field($field)->where($where)->page($page,BROWSE_PAGE_SIZE)->group('id');
        $rows = $model->select();

        $tree_value = convertCommoditiesForHtml($rows);
        dump($rows);
        dump($tree_value);
        return $tree_value;
    }


}