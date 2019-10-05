<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/29
 * Time: 19:42
 */

namespace app\oj\model;


use think\Exception;
use think\Model;

class SubmitModel extends Model
{
    protected $table = 'submit';

    public function get_all_submit($where)
    {
        try {
            $info = $this->field(['user_id', 'nick', 'problem_id', 'status', 'time', 'memory', 'submit_time'])
                ->where($where)->order('submit_time')->select()->toArray();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }

    public function get_the_submit($where)
    {
        try {
            $info = $this->field(['user_id', 'problem_id', 'language', 'status', 'time', 'memory', 'submit_time'])
                ->where($where)->order('submit_time')->select()->toArray();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }

    public function add_submit($data)
    {
        $info = $this->strict(false)->insert($data);
        if ($info === 0) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
        return ['code' => CODE_SUCCESS, 'msg' => '提交成功', 'data' => $info];
    }
}