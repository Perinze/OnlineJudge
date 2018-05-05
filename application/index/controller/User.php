<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 下午12:50
 */
namespace app\index\Controller;

use think\Log;

require_once "UserValidate.php";

class User extends Base{
    public function changeInfo()
    {

    }

    public function changeType($userId,$type)
    {
        if($this->checkToken(input('post.token'))!==true)
        {
            $ret = array('errCode'=>403,'errMsg'=>'token error','data'=>null);
            return json($ret);
        }

        if($this->checkUserType(session('userId'))<=1)
        {
            $ret = array('errCode'=>403,'errMsg'=>'没有操作权限','data'=>null);
            return json($ret);
        }

        $result = Db('user')->where('userId',$userId)->setField('type',$type);
        if(!$result)
        {
            $ret = array('errCode'=>102,'errMsg'=>'修改失败','data'=>null);
            return json($ret);
        }else {
            $time = date("Y-m-d H:i:s",time());
            $sessionuid = session('userId');
            Log::info("Opt {$time} [{$sessionuid}] Change User $userId");
            $ret = array('errCode' => 0, 'errMsg' => 'OK', 'data' => null);
            return json($ret);
        }
    }
}