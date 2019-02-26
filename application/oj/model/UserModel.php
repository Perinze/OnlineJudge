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
            $info = $this->insert($data);
            if(empty($info)){
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功',  'data' => $info];
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

    public function editUser($data) {
        try{
            $info = $this->where('id', $data['id'])->update($data);
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
            return $this->where('user_id', $user_id)->find();
        }catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常',  'data' => $e->getMessage()];
        }
    }

    public function searchUserByNick($nick) {
        try {
            return $this->where('nick', $nick)->find();
        }catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常',  'data' => $e->getMessage()];
        }
    }
}