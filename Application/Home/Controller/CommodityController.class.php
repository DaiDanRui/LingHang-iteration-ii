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
            'release_date as publish_time',
            'star_numbers as save_num','message_numbers as msg_num','description',
            'deleted_date as deadline',
            'group_concat(path) as images',
            'nickname as name',
            'pic_path as url',
        );
        $where = 'commodity.publisher_id=user.user_id'
                .' AND commodity.commodity_id=picture.commodity_id'
                .' AND skill_or_reward=' ."'$type'";
        if(isset($_REQUEST['type'])){
            $typeOfCommodity = getCommodityTypesAssociate($_REQUEST['type']);
            $where .= ' AND type='."'$typeOfCommodity'";
        }
        //是否有进行搜索
        if(isset($_REQUEST['search'])){
//            $where['title'] = array('like','%'.I('key').'%');
            $where.= ' AND title like %'.I('key').'%';
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
//        dump($rows);
        convertCommoditiesForHtml('images','publish_time',$rows);
//        dump($rows);
        return $rows;
    }

    public function uploadPage(){
        if(isLogined()){
            $this->display('');
        }
        $this->display('');
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
            'type' =>getCommodityTypesAssociate($_POST['type']),
            'publisher_id' => $_SESSION[CURRENT_LOGIN_ID]     ,
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
        $table = array(
            'tbl_commodity' =>'commodity','tbl_picture' =>'picture' ,'tbl_user' =>'user'
        );
        $field = array(
            'publisher_id','title','price',
            'release_date as publish_time',
            'description',
            'star_numbers as save_num',
            'message_numbers as msg_num',
            'picture.path as commodity_url',
            'nickname as username',
            'pic_path as avatar_url',
            'min(picture_id) as picture_id',
        );
        $where = array('commodity.commodity_id'=>$commodity_id,);
        $model = new CommodityModel();
        $model->table($table)->field($field)->where($where)
              ->where('commodity.publisher_id=user.user_id AND commodity.commodity_id=picture.commodity_id')
              ->group('commodity.commodity_id');
        $rows = $model->select();

        $row = &$rows[0];
        $publish_time = &$row['publish_time'];
        $publish_time = getBeforetime($publish_time);
        $row['id'] = $commodity_id;

        $message = $this->_getMessage($commodity_id);
        return array(
            'msg'=>$message,
            'commodity'=>$row,
        );
    }

    /**
     * @param $commodity_id
     * @param $model CommodityModel
     * @return array
     */
    private function _getMessage($commodity_id){

        $tables = array('tbl_user'=> 'user','tbl_message'=>'message');
        $fields = array(
            'message.content as description',
            'message.time as publish_time',
            'user.nickname as username',
            'user.pic_path as avatar_url'
        );
        $where  = array('message.commodity_id'=>$commodity_id,);
        $model = new MessageModel();
        $rows = $model->table($tables)->field($fields)->where($where)->where('message.talker_id=user.user_id')->select();
        foreach($rows as $row){
            $publish_time = &$row['publish_time'];
            $publish_time = getBeforetime($publish_time);
        }
        return $rows;
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