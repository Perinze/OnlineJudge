<?php


namespace app\panel\model;


use think\Exception;
use think\Model;

class SubmitModel extends Model
{
    protected $table = 'submit';

    public function getAllSubmit($where, $limit, $offset)
    {
        try{
            $info = $this
                ->where($where)
                ->limit($limit, $offset)
                ->withAttr('status', function($value) {
                    $status = [-1=>'删除', 0=>'禁用', 1=>'正常'];
                    return $status[$value];
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
}