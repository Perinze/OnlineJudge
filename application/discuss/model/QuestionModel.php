<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/3/1
 * Time: 下午11:19
 */
namespace app\discuss\model;

use think\Exception;
use think\Model;

class QuestionModel extends Model {
    protected $table = 'question';

    /**
     * 新建问题
     * @param $data : $user_id $contest_id $problem_id $title $content
     * @return array
     */
    public function newQuestion($data) {
        try {
            $res = $this->insert($data);
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'发表问题成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'发表问题失败', 'data'=>'重复发表'];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    /**
     * 删除Question
     * 该function在大部分时候不应该被调用
     * @param $question_id
     * @return array
     */
    public function deleQuestion($question_id) {
        try {
            $res = $this->where('question_id',$question_id)->delete();
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'删除问题成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'删除问题失败', 'data'=>''];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    /**
     * 根据比赛编号(可能是null)-题目编号来查找question项
     * 若比赛编号是null，则在全部公共题目里查找question项
     * @param $contest_id
     * @param $problem_id
     * @return array
     */
    public function searchQuestionByContestProblem($contest_id, $problem_id) { // TODO check logic of if not-in-contest ,there has some bugs
        try {
            $condition = [];
            if($contest_id!=null){
                $condition = ['contest_id'=>$contest_id, 'problem_id'=>$problem_id];
            }else{
                $condition = ['problem_id'=>$problem_id];
            }
            $content = $this->where($condition)->select();
            if(!empty($res)){
                return ['code'=>CODE_SUCCESS, 'msg'=>'查找成功', 'data'=>$content];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'查找失败', 'data'=>'不存在查找项'];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    /**
     * 根据question编号找到question项
     * @param $question_id
     * @return array
     */
    public function searchQuestion($question_id) {
        try {
            $content = $this->where('question_id',$question_id)->select();
            if(!empty($res)){
                return ['code'=>CODE_SUCCESS, 'msg'=>'查找成功', 'data'=>$content];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'查找失败', 'data'=>''];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    public function editQuestion() {  // TODO this block of code really should be exist?

    }
}