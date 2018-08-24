<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 上午9:43
 */
namespace app\index\Controller;

use app\index\model\UserModel;
use think\Request;

require_once "UserValidate.php";

class Login extends Base{
    /**
     * 用户登陆
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login() {
        $ret = array('errCode'=>0,'errMsg'=>'OK','data'=>null);
        $data = array(
            'account' => input('post.account'),
            'password' => md5(base64_encode(input('post.password')))
        );
        if(true === $this->validate($data,'app\index\validate\UserValidate.login'))
        {
            $user = Db('user')->where($data)->find();
            if($user)
            {
                session('userId',$user['userId']);
                session('userType',$user['userrType']);
            }else{
                $ret = array('errCode'=>102,'errMsg'=>'用户名或密码错误','data'=>null);
            }
        }
        return json($ret);
    }

    /**
     * 管理员登陆
     */
    public function adminlogin(Request $request) {
        if($request->isPost())
        {
            $user = new UserModel();
            $account = input('post.account');
            $password = md5(base64_encode(input('post.password')));
            $info = $user->checkAdmin($account,$password);
            if($info !== false)
            {
                session('userId',$info['userId']);
                $this->redirect('index/Panel/index');
            }else{
                $this->error('用户名密码错误或不是管理员');
            }
        }
        return $this->fetch('panel/login');
    }
}