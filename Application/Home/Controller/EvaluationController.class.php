<?php
/**
 * Created by PhpStorm.
 * User: darxan
 * Date: 2016/4/12
 * Time: 13:16
 */

namespace Home\Controller;


use Home\Model\EvaluationModel;
use Home\Model\TransactionModel;
use Think\Controller;

class EvaluationController extends Controller
{

    public function evaluatedPage(){
        if(isLogined()){
            $this->display('');
        }else{
            $this->success('','');
        }
    }

    public function myEvaluation(){
        $evaluator = $_SESSION[CURRENT_LOGIN_ID];
        $where = 'evaluation.evaluator_id='."'$evaluator'".' AND evaluation.evaluated_id=user.user_id';
        $array_for_html = $this->__commonEvaluation($where);
        dump($array_for_html);
    }

    public function myEvaluated(){

        $evaluated_id = $_SESSION[CURRENT_LOGIN_ID];
        $where = 'evaluation.evaluated_id='."'$evaluated_id'"
                .' AND evaluation.evaluator_id=user.user_id';
        $array_for_html = $this->__commonEvaluation($where);
        dump($array_for_html);
    }


    private function __commonEvaluation($where){
        if(!isLogined()){
            $this->success('','');
            return false;
        }
        $page = I('page');
        $tables = array(
            'tbl_evaluation'=> 'evaluation',
            'tbl_user' => 'user',
            'tbl_commodity'=>'commodity',
            'tbl_transaction'=>'transaction',
        );
        $fields = array(
            'evaluation.score1 as point_study',
            'evaluation.score2 as point_care',
            'evaluation.score3 as point_total',
            'user.pic_path as url_header',
            'user.nickname as username',
            'commodity.price',
            'commodity.title',
            'commodity.commodity_id',
        );
        $where .= ' AND evaluation.transaction_id=transaction.transaction_id'
                .' AND transaction.commodity_id=commodity.commodity_id';
        $model = new EvaluationModel();
        $evaluation_array = $model->table($tables)->field($fields)->page($page)->where($where)->select();
        dump($evaluation_array);
        return $evaluation_array;
    }



    /**
     * 1.检查是否当前用户存在权限评价
     * 2.如果权限错误则返回
     * 3.存在权限则评价成功
     * @return mixed|void|int
     */
    public function evaluate(){

        if(!isLogined()){
            $this->success('','');
            return 0;
        }
            $transaction_id = I('transaction_id');
            $evaluation = I('content');
            $evaluation_time = getCurrentTime();
            $evaluator_id = $_SESSION['CURRENT_LOGIN_ID'];;
            $score1 = I('score1');
            $score2 = I('score2');
            $score3 = I('score3');

            $transactionModel = new TransactionModel();
            $tables = array('tbl_transaction transaction','tbl_commodity commodity');
            $where = array('transaction_id'=>$transaction_id);
            $fields = array('publisher_id','trader_id');
            $commodity_message = $transactionModel->table($tables)->where($where)->field($fields)->select();


            if($evaluator_id==$commodity_message['publisher_id']){
                $evaluated_id = $commodity_message['trader_id'];
            }elseif($evaluator_id==$commodity_message['trader_id']){
                $evaluated_id = $commodity_message['publisher_id'];
            }else{
                $this->error('');
                return 0;
            }

            $model = new EvaluationModel();
            $evaluation_array = array(
                'transaction_id'=>$transaction_id,
                'evaluation_time'=>$evaluation_time,
                'evaluation'=>$evaluation,
                'evaluator_id'=>$evaluator_id,
                'evaluated_id'=>$evaluated_id,
                'score1'=>$score1,
                'score2'=>$score2,
                'score3'=>$score3
            );
            $result = $model->add($evaluation_array);
            dump($result);
            return $result;

    }
}