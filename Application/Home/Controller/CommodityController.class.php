<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/9
 * Time: 20:18
 */

namespace Home\Controller;


use Home\Model\CommodityModel;
use Home\Model\MessageModel;
use Home\Model\PictureModel;
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
        $field = array(
            'commodity.commodity_id as id',
            'publisher_id',
            'title','price',
            'release_date as time',
            'star_numbers','message_numbers','description',
            'group_concat(path) as imgs',
            'nickname as name',
            'pic_path as url',
        );
        $where = 'commodity.publisher_id=user.user_id'
                .' AND commodity.commodity_id=picture.commodity_id'
                .' AND skill_or_reward=' ."'$type'";
        //是否有进行搜索
        if(isset($_REQUEST['search'])){
            $where['title'] = array('like','%'.I('search').'%');
        }
        //排序控制
        $order = null;
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
        $model->table($table)->field($field)->where($where)->order($order)->page($page,BROWSE_PAGE_SIZE);
        $rows = $model->group('id')->select();
        dump($rows);
        convertCommoditiesForHtml('imgs','time',$rows);
        dump($rows);
        return $rows;
    }

    public function uploadPage(){
        if(isLogined()){
            $this->display('');
        }else{
            $this->success('','');
        }
    }

    /**
     * 上传
     */
    public function upload()
    {
        if(!isLogined()){
            $this->success('','');
        }
        $commodity_message = array(
            'course_or_reward'  => (int)I('course_or_reward'),
            'type' =>isset($_POST['type'])?  I('type'):'其他' ,
            'publisher_id' => $_SESSION['CURRENT_LOGIN_ID']     ,
            'price' => (int)I('price') ,
            'release_date' =>  getCurrentTime(),
            'deleted_date' => I('time'),
            'title' => I('topic'),
            'description' => I('description')  	,
            'communication_number' => I('phone')
            );
        $model = new CommodityModel();
        $result = $model->add($commodity_message);
        dump($result);
        if($result){
            $this->uploadPictures($result);
        }
    }

    private function uploadPictures($commodity_id){
        $picturePaths = getUploadPicturesAndMove();
        $pictures = array();
        foreach ($picturePaths as $path){
            $pictures[] = array('commodity_id'=>$commodity_id,'path'=>$path);
        }
        $model = new PictureModel();
        $last_id = $model->addAll($pictures);
        dump($last_id);
    }
    /**
     * 详细查看某一个具体悬赏或者技能
     * 包括商品信息，留言信息
     */
    public function details()
    {
        $commodity_id = I('id');
        $table = array('tbl_commodity' =>'commodity','tbl_picture' =>'picture' ,'tbl_user' =>'user');
        $field = array(
            'publisher_id','title','price','release_date','description',
            'star_numbers','message_numbers', 'path','nickname','pic_path',
        );
        $where = array('commodity.commodity_id'=>$commodity_id,);
        $model = new CommodityModel();
        $model->table($table)->field($field)->where($where)
              ->where('commodity.publisher_id=user.user_id AND commodity.commodity_id=picture.commodity_id');
        $rows = $model->select();

        $url = array();
        foreach ($rows as $row){
            $url[] = $row['path'];
        }
        $row = $rows[0];
        $tree_value = array(
            'img' => $row['pic_path'], //发布人头像
            'description' => $row['description'],
            'title' => $row['title'],
            'price' => $row['price'],
            'nickname' => $row['nickname'],
            'time' => getBeforetime($row['release_date']),
            'star_numbers' => $row['star_numbers'],
            'message_numbers' => $row['message_numbers'],
            'id' => $commodity_id,
            'description-img'=> $url, //商品图片
        );
        dump($tree_value);
        $messageArray = $this->_getMesssage($commodity_id);
        dump($messageArray);
    }

    /**
     * @param $commodity_id
     * @param $model CommodityModel
     * @return array
     */
    public function _getMesssage($commodity_id){

        $tables = array('tbl_user'=> 'user','tbl_message'=>'message');
        $fields = array('message.content','message.time','user.nickname','user.pic_path');
        $where  = array('message.commodity_id'=>$commodity_id,);
        $model = new MessageModel();
        $rows = $model->table($tables)->field($fields)->where($where)->where('message.talker_id=user.user_id')->select();
        $array_message = array();
        foreach ($rows as $temp_database_row_array) {
            $array_message[] = array(
                'description' => $temp_database_row_array['content'],
                'time' => getBeforetime($temp_database_row_array['time']),
                'nickname' => $temp_database_row_array['nick_name'],
                'img' => $temp_database_row_array['pic_path'],//'upload/avatar.png',
            );
        }
        return $array_message;
    }

    /**
     * star ,点赞并收藏
     */
    public function praise()
    {
        $commodity_id = I('id');
        $praiser_id = $_SESSION[CURRENT_LOGIN_ID];
        $model = new MessageModel();
        $praiseArray = array(
            'commodity_id'=>$commodity_id,
            'praiser_id'=>$praiser_id,
        );
        $result = $model->add($praiseArray);
        if(!$result){
            $this->error('');
        }else{
            $where = array('commodity_id'=>$commodity_id);
            $result = $model->table('tbl_commodity')->where($where)->setInc('praise',1);
            dump($result);
        }
    }

}