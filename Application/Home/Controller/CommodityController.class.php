<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/9
 * Time: 20:18
 */

namespace Home\Controller;


use Home\Model\CommodityModel;
use Home\Model\PictureModel;
use Home\Model\PraiseModel;
use Think\Controller;

class CommodityController extends Controller
{


    public function skill(){
        $this->_browseInfo(SKILL);
    }
    public function reward(){
        $this->_browseInfo(REWARD);
    }
    /**
     * 浏览商品模式
     */
    public function browse()
    {
        $type = SKILL;
        if(isset($_REQUEST['type'])){
            $type = $_REQUEST['type']==REWARD? 1:2;
        }
        $array = $this->_browseInfo($type);
    }
    /**
     * 浏览商品模式
     */
    private function _browseInfo($type)
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
            'group_concat(path) as pic_url',
            'nickname as name',
            'pic_path as avatar_url',
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
        convertCommoditiesForHtml('pic_url','publish_time',$rows);

        $this->assign('commodities',$rows);
        $this->assign('currentUsername',$_SESSION[CURRENT_LOGIN_USERNAME]);
        $this->assign('currentUserPhone',$_SESSION[CURRENT_LOGIN_PHONE]);
        $this->assign('isLogin',isLogined());
        $this->assign('type',$type);
        $this->display('main/market-main');
    }

    public function uploadPage($type){
        if(isLogined()){
            $this->error('');
        }
        $this->assign('type',$type);
        $this->display('main/market-skill-publish');
    }

    /**
     * 上传
     */
    public function upload()
    {
        if(!isLogined()){
            $this->success(PLEASE_LOGIN,U('user/loginPage'));
        }
        $phone =  I('phone');
        $commodity_message = array(
            'skill_or_reward'  => I('course_or_reward')==1?1:2,
            'type' =>getCommodityTypesAssociate($_POST['type']),
            'publisher_id' => $_SESSION[CURRENT_LOGIN_ID]     ,
            'price' => (int)I('price') ,
            'release_date' =>  getCurrentTime(),
            'deleted_date' => getCurrentTime(),//deadline
            'title' => I('title'),
            'description' => I('description')
            );
        $model = new CommodityModel();
        $result = $model->add($commodity_message);
        if($result){
            $this->_uploadPictures($result);
            $this->success('commodity/browse');
        }
    }


    private function _uploadPictures($commodity_id){
        import('@/Logic/FileUpload');
        $pictureInfo = getUploadPicturesAndMove();
        $pictures = array();
//        dump($pictureInfo);

        foreach ($pictureInfo as $path){
            $pictures[] = array('commodity_id'=>$commodity_id,'path'=>$path['savepath'].$path['savename']);
        }
//        dump($pictures);
//        exit;
        $model = new PictureModel();
        $model->addAll($pictures);
    }


    public function details(){

        $message = $this->detailsInformation();
        foreach($message as $key=>$value ) {
            $this->assign($key,$value);
        }
        $this->display('main/market-skill');
    }


    /**
     * 详细查看某一个具体悬赏或者技能
     * 包括商品信息，留言信息
     */
    public function detailsInformation()
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


    public function getMessageJson(){
        $commodity_id = I('id');
        $array = $this->_getMessage($commodity_id);
        $this->ajaxReturn($array);
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

}