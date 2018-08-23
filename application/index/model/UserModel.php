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
                'userNick'=>$uid,
                'userPasswd'=>$passwd
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

    public function getuserinfo()
    {
        try{
            $info = $this->order(['userType'=>'desc'])
                ->field('userId,userType,userStat,userGender,userMail,userPhone,userName,userNick')
                ->select();
            if($info)return $info->toArray();
        }catch (DbException $e) {
            return false;
        }
        return false;
    }
}