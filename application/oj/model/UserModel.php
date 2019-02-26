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

    public function addUser() {

    }

    public function deleUser($user_id) {
        $this->where('user_id',$user_id)->delete();
    }

    public function editUser() {

    }

    public function searchUserById($user_id) {
        try{
            return $this->where('user_id', $user_id)->find();
        }catch (Exception $e) {
            return null;
        }
    }

    public function searchUserByNick($nick) {
        try {
            return $this->where('nick', $nick)->find();
        }catch (Exception $e) {
            return null;
        }
    }
}