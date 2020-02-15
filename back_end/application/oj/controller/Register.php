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
    /**
     * 注册
     */
    public function register()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();

        $req = input('post.');
        $result = $user_validate->scene('register')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        if ($req['password'] !== $req['password_check']) {
            return apiReturn(CODE_ERROR, '两次输入密码不一致', '');
        }

        // register
        $resp = $user_model->addUser(array(
            'nick' => $req['nick'],
            'password' => md5(base64_encode($req['password'])),
            'avatar' => isset($req['avatar']) ? $req['avatar'] : '../uploads/image/20200214/fc3d5f691e86c9f621621682c57de59b.jpg',
            'realname' => $req['realname'],
            'school' => $req['school'],
            'major' => $req['major'],
            'class' => $req['class'],
            'contact' => $req['contact'],
            'mail' => $req['mail'],
        ));

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}