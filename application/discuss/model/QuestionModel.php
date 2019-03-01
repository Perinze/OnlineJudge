<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/3/1
 * Time: 下午11:19
 */
namespace app\discuss\model;

use think\Model;

class QuestionModel extends Model {
    protected $table = 'question';

    /**
     * @param $data : $user_id $question_id $content
     */
    public function newComment($data) {

    }

    public function searchComment($comment_id) {

    }

    /*
     * I think this function should not be exist
     */
    public function editComment($comment_id) {

    }

    public function deleComment($comment_id) {

    }
    /*
     * end
     */
}