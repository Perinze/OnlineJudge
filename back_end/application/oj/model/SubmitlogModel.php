<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/29
 * Time: 19:56
 */

namespace app\oj\model;


use think\Exception;
use think\Model;

class SubmitlogModel extends Model
{
    protected $table = 'submit_log';

    public function add_log($data)
    {
        try {
            $info = $this->strict(false)->insert($data);
            if ($info != true) {
                return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }

    public function get_the_log()
    {
        try {
            $info = $this->whereTime('time', '-312 hours')->select();
            if ($info == false) {
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info->toArray()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }

    public function get_all_log()
    {
        try {
            $ac = $this->whereTime('time', '>', '1900-01-01')->sum('ac');
            $data = $this->whereTime('time', '>', '1900-01-01')->sum('submit');
            $info = array(
                'ac' => $ac,
                'submit' => $data,
            );
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }
}