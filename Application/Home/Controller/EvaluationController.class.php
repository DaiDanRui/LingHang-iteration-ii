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

    public function myEvaluation(){}

    /**
     *
     */
    public function myEvaluationSkill(){
        if(!isLogined()){
            $this->success('','');
            return;
        }
        $evaluator = $_SESSION[CURRENT_LOGIN_ID];
        $tables = array('tbl_evaluation evaluation','tbl_user user');
        $fields = array('evaluation.*,user.pic_path,user.nickname');
        $where = array('evaluation.evaluator_id'=>$evaluator,'user.user_id'=>'evaluation.evaluator_id');
        $model = new EvaluationModel();
        $evaluation_array = $model->table($tables)->field($fields)->where($where)->select();
        dump($evaluation_array);
        $array_for_html = $this->__convertForHtml($evaluation_array);
        dump($array_for_html);
    }

    public function myEvaluated(){
        if(!isLogined()){
            $this->success('','');
            return;
        }
        $evaluated_id = $_SESSION[CURRENT_LOGIN_ID];
        $tables = array('tbl_evaluation evaluation','tbl_user user');
        $fields = array('evaluation.*,user.pic_path,user.nickname');
        $where = array('evaluation.evaluated_id'=>$evaluated_id,'user.user_id'=>'evaluation.evaluator_id');
        $model = new EvaluationModel();
        $evaluation_array = $model->table($tables)->field($fields)->where($where)->select();
        dump($evaluation_array);
        $array_for_html = $this->__convertForHtml($evaluation_array);
        dump($array_for_html);
    }

    public function evaluatedPage(){
        if(isLogined()){
            $this->display('');
        }else{
            $this->success('','');
        }
    }
    
    private function __convertForHtml($evaluation_array){
        $array_for_html = array();
        foreach ($evaluation_array as $row) {
            $array_for_html[] = array(
                'url_header' =>$row['pic_path'],
                'title' => $row['title'],
                'price' => $row['price'],
                'username' => $row['nickname'],
                'point_study' => $row['score1'],
                'point_care' => $row['score2'],
                'point_total' => $row['score3'],
                'time' => $row['evaluate_time'],
            );
        }
        return $array_for_html;
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
            $result = $model->table('tbl_evaluation evaluation')
                ->add($evaluation_array);
            dump($result);
            return $result;

    }
}