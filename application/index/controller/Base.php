<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 上午8:45
 */
namespace app\index\Controller;

use think\Controller;

class Base extends Controller{
//    protected function tokenGenerate()
//    {
//        $hash = bin2hex(random_bytes(16));
//        cache($hash,md5(time()));
//        return $hash;
//    }
//
//    protected function checkToken($token)
//    {
//        if(strlen($token)==32)
//        {
//            $data = app('cache')->pull($token);
//            if($data)return true;
//        }
//        return false;
//    }

    protected function checkUserType($userId)
    {
        $result = Db('user')->where('userId',$userId)->find();
        return $result;
    }

    protected function checkRcode($rcode)
    {
        if(strlen($rcode)==16)
        {
            $data = Db('rcode')->where('code',$rcode)->find();
            if($data['isUsed']==false)
            {
                Db('rcode')->where('code',$rcode)->setField('isUsed',true);
                return true;
            }
        }
        return false;
    }
}