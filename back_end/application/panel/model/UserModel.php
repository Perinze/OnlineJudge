<?php


namespace app\panel\model;


use think\Exception;
use think\Model;

class UserModel extends Model
{
    protected $table = 'users';
    public function getAllUser($where, $limit, $offset)
    {
        try{
            $field = ['user_id', 'nick', 'realname', 'school', 'major', 'class', 'identity', 'status'];
            $info = $this->field($field)
                ->where($where)
                ->limit($offset, $limit)
                ->withAttr('identity', function($value) {
                    $status = [-1=>'删除', 0=>'正常用户', 1=>'学生', 2=>'教师', 3=>'管理员'];
                    return $status[$value];
                })
                ->withAttr('status', function($value) {
                    $status = [-1=>'删除', 0=>'正常'];
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