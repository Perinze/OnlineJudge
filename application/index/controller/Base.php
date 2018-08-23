<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 上午8:45
 */
namespace app\index\Controller;

use think\Controller;
use think\Exception;

class Base extends Controller{
    /**
     * view文件夹外调用：生成token（之后可能考虑关闭此方法）
     * @return string
     * @throws \Exception
     */
    public static function tokenGenerate()
    {
        $hash = bin2hex(random_bytes(16));
        cache($hash,md5(time()));
        return $hash;
    }

    /**
     * 验证token有效性
     * @param $token
     * @return bool
     */
    protected function checkToken($token)
    {
        if(strlen($token)==32)
        {
            $data = app('cache')->pull($token);
            if($data)return true;
        }
        return false;
    }

    /**
     * 检查用户身份级别
     * @param $userId
     * @return array|null|\PDOStatement|string|\think\Model
     */
    protected function checkUserType($userId)
    {
        try {
            $result = Db('user')->where('userId', $userId)->field('userType')->find();//TODO check
            return $result;
        }catch (Exception $e) {
            return -1;
        }
    }

    /**
     * 检查邀请码有效性
     * @param $rcode
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
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