<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/8/22
 * Time: 下午6:32
 */
namespace app\index\model;

use think\exception\DbException;
use think\Model;

class UserModel extends Model{
    protected $table = 'user';

    public function checkAdmin($uid,$passwd)
    {
        try{
            $info = $this->where([
                'account'=>$uid,
                'password'=>$passwd
            ])->find();
            if($info)
                if($info['userType']>=2)
                    return $info->toArray();
        }catch (DbException $e) {
            return false;
        }
        return false;
    }

    public function getinfo($uid)
    {
        try{
            $info = $this->where([
                'userId'=>$uid
            ])->find();
            if($info)return $info->toArray();
        }catch (DbException $e) {
            return false;
        }
        return false;
    }
}