<?php


namespace app\panel\model;


use think\Db;
use think\Exception;
use think\exception\DbException;
use think\Model;

class SubmitModel extends Model
{
    protected $table = 'submit';

    public function getAllSubmit($where, $limit, $offset)
    {
        try{
            $field = ['id', 'user_id', 'nick', 'problem_id', 'language', 'status', 'time', 'memory', 'submit_time'];
            $info = $this->field($field)
                ->where($where)
                ->limit($limit, $offset)
                ->withAttr('language', function($value) {
                    $language = [0=>'c.gcc', 1=>'cpp.g++', 2=>'java.openjdk10', 3=>'python.cpython3.6'];
                    return $language[$value];
                })
                ->select()
                ->toArray();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function getSubmitGroup($where) {
        try {
            $res = $this->field(['id','user_id','nick', 'problem_id', 'language', 'status', 'time', 'memory', 'submit_time', 'source_code'])
                ->where($where)
                ->withAttr('language', function($value) {
                    $language = [0=>'c.gcc', 1=>'cpp.g++', 2=>'java.openjdk10', 3=>'python.cpython3.6'];
                    return $language[$value];
                })->select();
            if (count($res) != 0) {
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $res];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $res];
            }

        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => "数据库错误", 'data' => $e->getMessage()];
        }
    }

    public function getTheSubmit($id){
        try {
            $info = $this->field(['id','user_id','nick', 'problem_id', 'language', 'status', 'time', 'memory', 'submit_time', 'source_code'])
                ->where('id', $id)
                ->withAttr('language', function($value) {
                    $language = [0=>'c.gcc', 1=>'cpp.g++', 2=>'java.openjdk10', 3=>'python.cpython3.6'];
                    return $language[$value];
                })
                ->find();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }
}