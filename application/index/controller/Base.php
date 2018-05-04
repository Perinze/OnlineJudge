<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 上午8:45
 */
namespace app\index\Controller;

use think\Controller;
use think\Db;

class Base extends Controller{
    protected function tokenGenerate()
    {
        $hash = bin2hex(random_bytes(16));
        cache($hash,md5(time()));
        return $hash;
    }

    protected function checkToken($token)
    {
        if(strlen($token)==32)
        {
            $data = app('cache')->pull($token);
            if($data)return true;
        }
        return false;
    }

    protected function checkUserType($userId)
    {
        $result = Db('user')->where('userId',$userId)->find();
        return $result;
    }
}