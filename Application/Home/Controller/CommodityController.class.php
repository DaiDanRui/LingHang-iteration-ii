<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/9
 * Time: 20:18
 */

namespace Home\Controller;


use Home\Model\CommodityModel;
use Think\Controller;

class CommodityController extends Controller
{

    /**
     * 浏览商品模式
     */
    public function browse($type)
    {

        $page = (int) I('page');
        $table = array('tbl_commodity' =>'commodity','tbl_picture' =>'picture' ,'tbl_user' =>'user');
        $where = array();
        $field = array('commodity.commodity_id','publisher_id','title','price','release_date',
            'star_numbers','message_numbers',
            'path','nickname','pic_path',
            );



        $where['skill_or_reward'] = $type;
        //是否有进行搜索
        if(isset($_REQUEST['search'])){
            $where['title'] = array('like','%'.I('search').'%');
        }
        //排序控制
        if(isset($_POST['price-high'])){//价格最高的
            $order=('price desc')  ;
        }else if(isset($_POST['price-low'])){//价格最低的
            $order=('price');
        }else if(isset($_POST['time-new'])){//
            $order=('release_date') ;
        }else if(isset($_POST['time-old'])){
            $order=('release_date desc') ;
        }

        $model = new CommodityModel();
        $model
            ->table($table)
            ->field($field)
            ->where($where)
            ->where('commodity.publisher_id=user.user_id AND commodity.commodity_id=picture.commodity_id')
            ->order($order)
            ->page($page,C('PAGE_SIZE'));
        $rows = $model->select();

        $tree_value = array();
        foreach ($rows as $row){
            if(key_exists($row['commodity_id'],$tree_value)){
                $urls = $tree_value[$row['commodity_id']];
                $urls[] = $row['path'];
            }
            else{
               $tree_value[] = array(
                    'imgs' => $row['pic_path'],
                    'description' => $row['description'],
                    'title' => $row['title'],
                    'price' => $row['price'],
                    'url' =>   $row['path'], //'upload/default.jpg',
                    'name' => $row['nickname'],
                    'time' => get_time($row['release_date']),
                    'star_numbers' => $row['star_numbers'],
                    'message_numbers' => $row['message_numbers'],
                    'id' => $row['commodity_id'],
                );
            }

        }

        return $tree_value;


    }

    /**
     * 上传
     */
    public function upload($type)
    {
        $pic_path = '';
        $commodity_message = Array
        (
            'course_or_reward'  => (int)I['course_or_reward'],
            'type' =>isset($_POST['type'])?  I('type'):'其他' ,
            'publisher_id' => $_SESSION['CURRENT_LOGIN_ID']     ,

            'price' => (int)I('price') ,
            'release_date' =>  getCurrentTime(),
            'deleted_date' => I('time'),

            'title' => Injection::excute('topic'),
            'description' => Injection::excute('description')  	,

            'pic_path' => $pic_path ,
            'communication_number' => Injection::excute('phone')
        );
        $model = new CommodityModel();
        $result = $model->add($commodity_message);
        dump('result');
    }

    /**
     * 详细查看某一个具体悬赏或者技能
     * 包括商品信息，留言信息
     */
    public function details()
    {
    }

    /**
     * star ,点赞并收藏
     */
    public function praise()
    {
        $where = array('commodity_id'=>I('id'));
        $model = new CommodityModel();
        $result = $model->where($where)->setInc('praise',1);
        dump($result);
    }

    /**
     * 我要接受某一订单
     */
    public function accept()
    {
        senderSMS('18795855867','PS','1','187196855867');
    }
}