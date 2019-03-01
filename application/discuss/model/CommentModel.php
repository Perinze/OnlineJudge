<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/3/1
 * Time: 下午11:20
 */
namespace app\discuss\model;

use think\Model;

class CommentModel extends Model {
    protected $table = 'question';

    /**
     * @param $data : $user_id $contest_id $problem_id $title $content
     */
    public function newQuestion($data) {

    }

    /**
     * 该function在大部分时候不应该被调用
     * @param $question_id
     */
    public function deleQuestion($question_id) {

    }

    /**
     * 根据比赛编号(null)-题目编号来查找question
     * @param $contest_id
     * @param $problem_id
     */
    public function searchQuestionByContestProblem($contest_id, $problem_id) { // TODO don't forget if not in contest logic

    }

    /**
     * 根据question编号找到question
     * @param $question_id
     */
    public function searchQuestion($question_id) {

    }

    public function editQuestion() {  // TODO this block of code really should be exist?

    }
}