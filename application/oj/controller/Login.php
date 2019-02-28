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

    // uncheck

    public function do_login()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        if(Session::has('user_id')){
            return apiReturn(CODE_ERROR, '请不要重复登录', '');
        }
        $req = input('post.');
        $result = $user_validate->scene('login')->check($req);
        if($result != true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $req['password'] = md5(base64_encode($req['password']));
        $result = $user_model->loginCheck($req);
        if($result['code']==CODE_SUCCESS){
            session('user_id',$req['user_id']);
            return apiReturn($result['code'],$result['msg'],$result['data']);
        }else{
            return apiReturn($result['code'],$result['msg'],$result['data']);
        }
    }

    public function do_logout()
    {
        session('user_id',null);
    }
}