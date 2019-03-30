<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/28
 * Time: 21:01
 */

namespace app\oj\controller;

use app\oj\model\UserModel;
use app\oj\validate\UserValidate;
use think\Controller;

class Register extends Controller
{
    public function register() {
        $req = input('post.');
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $result = $user_validate->scene('register')->check($req);
        if($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        if($req['password'] !== $req['password_check']){
            return apiReturn(CODE_ERROR, '两次输入密码不一致', '');
        }
        $req['ac_problem'] = json_encode(array());
        $req['wa_problem'] = json_encode(array());
        $req['submit_data'] = json_encode(array());
        $resp = $user_model->addUser($req);
        return apiReturn($resp['code'],$resp['msg'],$resp['data']);
    }
}