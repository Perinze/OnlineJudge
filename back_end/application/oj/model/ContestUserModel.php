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
                return ['code' => CODE_SUCCESS, 'msg' => '已参加比赛', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_PARAM_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function searchUserContest($user_id)
    {
        try{
            $info = $this->where('user_id', $user_id)->select()->toArray();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '无比赛信息', 'data' => ''];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (Exception $e) {
            return ['code' => CODE_PARAM_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function addInfo($contest_id, $user_id)
    {
        try{
            $info = $this->insert(['contest_id' => $contest_id, 'user_id' => $user_id]);
            if($info === false){
                return ['code' => CODE_ERROR, 'msg' => '参加失败，请重试', 'data' => ''];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '参加成功', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}