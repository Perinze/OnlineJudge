<?php


namespace app\oj\model;


use think\Exception;
use think\Model;

class ContestUserModel extends Model
{
    protected $table = 'contest_users';

    public function searchUser($contest_id, $user_id)
    {
        try{
            $info = $this->where([['contest_id', '=', $contest_id], ['user_id', '=', $user_id]])->find();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '未参加比赛', 'data' => ''];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => ''];
            }
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}