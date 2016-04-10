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

    /**
     * @var $userModel UserModel
     */
    protected $userModel;




    public function  loginPage(){
        $this->display('');
    }

    public function login(){

        $nickname = I('username');
        $input_password = I('pwd');
        $where = array('nickname'=>$nickname);
        $field = array('password','user_id');

        $this->userModel = new UserModel();
        $search_array = $this->userModel->field($field)->where($where)->select();

        if(!$search_array){ //null or false
            $this->error('nickname not exists');
        }else{
            $password = $search_array['password'];
            $user_id = $search_array['user_id'];
            if($password==$input_password){
                session('CURRENT_LOGIN_ID',$user_id) ;
                $this->success('success to login');
            }else{
                $this->error('wrong password');
            }
        }

    }

    public function registerPage(){
        $this->display('');
    }

    public function register(){
        $input_array=array(
            'nickname'=>I('username'),
            'password'=>I('pwd'),
            'phone'=>I('phone'),
            'is_seller' => 1,
            'create_time'=> getCurrentTime(),
            'last_log'=> getCurrentTime(),
            'account_state'=>1,

            'good_seller'=>5,
            'good_buyer'=>5,

            'pic_path' => 'avatar.jpg',
        );

        $result = $this->userModel->add($input_array);
        if($result){
            $this->success('register success');
        }else{
            $this->error('register error');
        }
    }

    public function logout(){
    }

}