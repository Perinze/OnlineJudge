<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午2:33
 */
namespace app\oj\controller;

use app\oj\model\UserModel;
use app\oj\validate\UserValidate;
use think\facade\Session;

class Login extends Base
{
    public function do_login()
    {
        // 检测重复登录
        if(Session::has('user_id')){
            return apiReturn(CODE_ERROR, '已有账号登录登陆', '');
        }
        // 正常登陆逻辑
        $user_validate = new UserValidate();
        $user_model = new UserModel();

        $req = input('post.');
        // 检测前端传送的用户登陆数据
        $result = $user_validate->scene('login')->check($req);
        if($result != true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        // 密码加密
        $req['password'] = md5(base64_encode($req['password']));
        // 身份验证
        $result = $user_model->loginCheck($req);
        if($result['code']==CODE_SUCCESS){
            // 验证成功，session分配
            session('user_id',$result['data']['user_id']);
        }
        return apiReturn($result['code'],$result['msg'],$result['data']);
    }

    public function do_logout()
    {
        session('user_id',null);
    }
}