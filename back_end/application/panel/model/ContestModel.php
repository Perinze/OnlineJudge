<?php


namespace app\panel\model;


use think\Exception;
use think\Model;

class ContestModel extends Model
{
    protected $table = 'contest';
    public function getAllContest($where, $limit, $offset)
    {
        try{
            $field = ['contest_id', 'contest_name', 'begin_time', 'end_time', 'status'];
            $info = $this->field($field)
                ->where($where)
                ->limit($offset, $limit)
                ->withAttr('status', function($value) {
                    $status = [-1=>'删除', 0=>'禁用', 1=>'正常'];
                    return $status[$value];
                })
                ->select();
            if($info === false){
                return ['code' => CODE_ERROR,'msg' => '返回值异常','data' => $this->getError()];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取成功', 'data' => $info->toArray()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR,'msg' => '操作数据库异常','data' => $e->getMessage()];
        }
    }
}