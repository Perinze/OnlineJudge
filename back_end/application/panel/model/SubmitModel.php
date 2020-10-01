<?php


namespace app\panel\model;


use think\Db;
use think\Exception;
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
                    $language = [0=>'c', 1=>'c++', 2=>'py', 3=>'java'];
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

    public function getTheSubmit($id){
        try {
            $info = $this->field(['id','user_id','nick', 'problem_id', 'language', 'status', 'time', 'memory', 'submit_time', 'source_code'])
                ->where('id', $id)
                ->withAttr('language', function($value) {
                    $language = [0=>'c', 1=>'c++', 2=>'py', 3=>'java'];
                    return $language[$value];
                })
                ->find();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }
}