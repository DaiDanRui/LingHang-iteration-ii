<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/12
 * Time: 13:28
 */

namespace Home\Controller;


use Home\Model\CommodityModel;
use Think\Controller;

/***
 * 我发布的技能与悬赏
 * Class MyCommodity
 * @package Home\Controller
 */
class MyCommodityController extends Controller
{
    /**
     * 我发布的技能
     */
    public function  publishSkill(){
        $this->publish(SKILL);
    }

    /**
     * 我发布的悬赏
     */
    public function publishReward(){
        $this->publish(REWARD);
    }

    /**
     * @param $type int REWARD or SKILL 技能或者悬赏
     * @return array
     */
    public function publish($type){

        $page = (int) I('page');
        $current_loginer = $_SESSION[CURRENT_LOGIN_ID];
        dump($current_loginer);
        $table = array('tbl_commodity' =>'commodity','tbl_picture' =>'picture');

        $where = array(
            'commodity.skill_or_reward'=>$type,
            'commodity.publisher_id'=>$current_loginer,
        );
        $field = array(
            'commodity.commodity_id','publisher_id','title','price','release_date','description',
            'star_numbers','message_numbers', 'path'
        );
        $model = new CommodityModel();
        $model->table($table)->field($field)->where($where)->page($page,BROWSE_PAGE_SIZE)
            ->where('commodity.commodity_id=picture.commodity_id');
        $rows = $model->select();

        $tree_value = $this->_convertCommoditiesToTree($rows);
        dump($rows);
        dump($tree_value);
        return $tree_value;
    }

    private function _convertCommoditiesToTree($tableRows){
        $tree_value = array();
        $currentLoginAvatar = $_SESSION[CURRENT_LOGIN_AVATAR];
        $nickname = $_SESSION[CURRENT_LOGIN_USERNAME];
        foreach ($tableRows as $row){
            $commodity_id = $row['commodity_id'];
            if(key_exists($commodity_id,$tree_value)){
                $temp_row = $tree_value[$commodity_id];
                $urls = $temp_row['url'];
                $urls[] = $row['path'];
            }
            else{
                $tree_value[$commodity_id] = array(
                    'imgs' => $currentLoginAvatar,
                    'description' => $row['description'],
                    'title' => $row['title'],
                    'price' => $row['price'],
                    'url' =>   array($row['path']), //'upload/default.jpg',
                    'name' => $nickname,
                    'time' => getBeforetime($row['release_date']),
                    'star_numbers' => $row['star_numbers'],
                    'message_numbers' => $row['message_numbers'],
                    'id' => $row['commodity_id'],
                );
            }
        }
        return $tree_value;
    }
}