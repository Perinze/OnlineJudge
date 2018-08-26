<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 下午12:50
 */
namespace app\index\Controller;

use app\index\model\UserModel;
use think\Log;

require_once "UserValidate.php";

class User extends Base{
    public function __construct()
    {
        parent::__construct();
        if($this->checkToken(input('post.token'))!==true)
        {
            $ret = array('errCode'=>403,'errMsg'=>'token error','data'=>null);
            return json($ret);
        }
    }

    /**
     * 更新个人资料
     * @param $userId
     * @param $mail
     * @param $phone
     * @param $name
     * @param $gender
     * @param $desc
     * @param $class
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function changeInfo($userId,$mail,$phone,$name,$gender,$desc,$class)
    {
        if(session('userId')!=$userId)
        {
            $ret = array('errCode'=>403,'errMsg'=>'没有操作权限','data'=>null);
            return json($ret);
        }

        $userInfo = Db('user')->where('userId',$userId)->find();

        $info = json(array('desc'=>$desc,'class'=>$class));

        $data = array();
        if($mail!=$userInfo['mail'])$data['mail']=$mail;
        if($phone!=$userInfo['phone'])$data['phone']=$phone;
        if($name!=$userInfo['name'])$data['name']=$name;
        if($gender!=$userInfo['gender'])$data['gender']=$gender;
        if($info!=$userInfo['info'])$data['info']=$info;

        $result = $this->validate($data,'app\index\validate\UserValidate.change');
        if($result !== true)
        {
            $ret = array('errCode' => 102, 'errMsg' => '表单数据格式有误', 'data' => $result);
            return json($ret);
        }

        $result = Db('user')->where('userId',$userId)->setField($data);
        if($result)
        {
            $ret = array('errCode' => 0, 'errMsg' => 'OK', 'data' => null);
        }else{
            $ret = array('errCode' => 102, 'errMsg' => '更新个人信息失败', 'data' => null);
        }
        return json($ret);
    }

    /**
     * 更改用户身份级别与在役状态
     * @param $userId
     * @param $type
     * @return \think\response\Json
     */
    public function changeStatus()
    {
        if($this->checkUserType(session('userId'))<=1)
        {
            $ret = array('errCode'=>403,'errMsg'=>'没有操作权限','data'=>null);
            return json($ret);
        }

        $userId = input('post.userId');
        $type = input('post.type');
        $status = input('post.status');
        $star = input('post.star');

        $user = new UserModel();
        $result = $user->changeInfo($userId,'userType',$type);
        $result &= $user->changeInfo($userId,'userStatus',$status);
        $result &= $user->changeInfo($userId,'star',$star);

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

    /**
     * 更改密码
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function changePassword()
    {
        $userId = input('post.userId');

        if(session('userId')!=$userId)
        {
            $ret = array('errCode'=>403,'errMsg'=>'没有操作权限','data'=>null);
            return json($ret);
        }

        $oriPassword = input('post.oriPassword');
        $newPassword = input('post.newPassword');
        $rePassword = input('post.rePassword');

        $check = Db('user')->where(array('userId'=>$userId,'password'=>md5(base64_encode($oriPassword))))->find();
        if($check)
        {
            if($newPassword!=$rePassword)
            {
                $ret = array('errCode'=>102,'errMsg'=>'两次密码不一致','data'=>null);
                return json($ret);
            }else{
                $result = Db('user')->where('userId',$userId)->setField('password',md5(base64_encode($newPassword)));
                if(!$result)
                {
                    $ret = array('errCode'=>102,'errMsg'=>'新密码与旧密码不能相同','data'=>null);
                    return json($ret);
                }
            }
        }else{
            $ret = array('errCode'=>102,'errMsg'=>'原密码错误','data'=>null);
            return json($ret);
        }
        $ret = array('errCode' => 0, 'errMsg' => 'OK', 'data' => null);
        return json($ret);
    }

    /**
     * 删除成员（仅有非正式成员可以删除）
     * @param $userId
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteUser($userId)
    {
        if($this->checkUserType(session('userId'))<=1)
        {
            $ret = array('errCode'=>403,'errMsg'=>'没有操作权限','data'=>null);
            return json($ret);
        }

        if($this->checkUserType($userId)>=1)
        {
            $ret = array('errCode'=>102,'errMsg'=>'管理员与正式成员无法删除,请使用数据库','data'=>null);
            return json($ret);
        }else{
            $result = Db('user')->where('userId',$userId)->delete();
            if($result)
            {
                $time = date("Y-m-d H:i:s",time());
                $sessionuid = session('userId');
                Log::info("Opt {$time} [{$sessionuid}] Delete User $userId");
            }else{
                $ret = array('errCode'=>102,'errMsg'=>'用户不存在','data'=>null);
                return json($ret);
            }
        }
        $ret = array('errCode' => 0, 'errMsg' => 'OK', 'data' => null);
        return json($ret);
    }

    public function adminAddUser()
    {

    }
}