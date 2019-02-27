<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午12:48
 */
namespace app\oj\model;

use think\Exception;
use think\Model;

class UserModel extends Model {
    protected $table = 'users';

    public function addUser($data) {
        try{
            $res = $this->insert($data);
            if($res){
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功',  'data' => ''];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '添加失败',  'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常',  'data' => $e->getMessage()];
        }
    }

    public function deleUser($user_id) {
        $this->where('user_id',$user_id)->delete();
        return ['code' => CODE_SUCCESS, 'msg' => '删除成功',  'data' => ''];
    }

    public function editUser($user_id, $data) {
        try{
            $info = $this->where('user_id', $user_id)->update($data);
            if($info != 0){
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功',  'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '更新失败',  'data' => ''];
            }
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库异常',  'data' => $e->getMessage()];
        }
    }

    public function searchUserById($user_id) {
        try{
            $content = $this->where('user_id', $user_id)->find();
            return ['code' => CODE_SUCCESS, 'msg' => '查找成功',  'data' => $content];
        }catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常',  'data' => $e->getMessage()];
        }
    }

    public function searchUserByNick($nick) {
        try {
            $content = $this->where('nick', $nick)->find();
            return ['code' => CODE_SUCCESS, 'msg' => '查找成功',  'data' => $content];
        }catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常',  'data' => $e->getMessage()];
        }
    }
}