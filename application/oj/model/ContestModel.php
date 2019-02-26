<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午12:47
 */
namespace app\oj\model;

use think\Exception;
use think\Model;

class ContestModel extends Model {
    protected $table = 'contest';

    public function searchContest($contest_id) {
        try {
            return $this->where('contest_id', $contest_id)->find();
        }catch (Exception $e) {
            return null;
        }
    }

    public function newContest() {

    }

    public function deleContest() {

    }

    public function editContest() {

    }
}