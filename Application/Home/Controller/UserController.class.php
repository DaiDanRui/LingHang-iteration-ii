<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 17:05
 */

namespace Home\Controller;
use Home\Model\UserModel;
use Think\Controller;

class UserController extends Controller
{


    public function passwordChanged(){
        $old_password = I('old');
        $new_password = I('new');
        $current_user = I(CURRENT_LOGIN_ID);
        $model = new UserModel();
        $where = array('user_id'=>$current_user);
        $actual_password = $model->field('password')->where($where)->select();
        if($actual_password==$old_password){
            $model->update(array('password'=>$new_password));
            $this->success('');
        }else{
            $this->error();
        }
    }
    public function passwordChangedPage(){}

    public function phoneChangedPage(){}
    public function phoneChanged(){}

    public function findPassword(){}
    public function findPasswordPage(){}

    public function setPhone(){}

    public function verifyCode(){
    }

    public function  loginPage(){
        $this->display('login/login');
    }


    public function login(){

        $nickname = I('username');
        $input_password = I('password');
        $where = array('nickname'=>$nickname);
        $field = array('password','user_id','pic_path','phone');

        $userModel = new UserModel();
        $search_array = $userModel->field($field)->where($where)->find();
        if(empty($search_array)){ //null or false
            $this->error('nickname not exists');
        }else{
            $password = $search_array['password'];
            dump($password);
            $user_id = $search_array['user_id'];
            $user_pic = $search_array['pic_path'];
            $user_phone = $search_array['phone'];
            if($password==$input_password){
                session(CURRENT_LOGIN_ID,$user_id) ;
                session(CURRENT_LOGIN_USERNAME,$nickname);
                session(CURRENT_LOGIN_AVATAR,$user_pic);
                session(CURRENT_LOGIN_PHONE,$user_phone);
                $this->success('success to login',U('skill/browse'),1);
            }else{
                $this->error('wrong password');
            }
        }

    }

    public function registerPage(){

        $this->display('login/register');
    }

    public function register(){
        $nickname = I('username');
        $password = I('password');
        $again = I('again');
        if($password!=$again){
            $this->error('not same!');
        }
        $model = new UserModel();
        $result=$model->where(array('nickname'=>$nickname))->select();
        dump($result);
        dump($model->getLastSql());

        if(!empty($result)){
            $this->error('用户名已经存在');
        }

        $input_array=array(
            'nickname'=>$nickname,
            'password'=>$password,
            'phone'=>I('phone'),
            'is_seller' => 1,
            'create_time'=> getCurrentTime(),
            'last_log'=> getCurrentTime(),
            'account_state'=>1,
            'good_seller'=>5,
            'good_buyer'=>5,
            'pic_path' => DEFAULT_AVATAR,
        );

        $result = $model->add($input_array);
        dump($result);
        if($result){
            $this->success('register success');
        }else{
            $this->error('register error');
        }
    }

    public function logout(){
        if(isLogined()){
            session('[destroy]');
            $this->error('成功登出',U('commodity/skill'),2);
        }else{
            $this->error('请先登录',U('user/loginPage'),1);
        }
    }

}