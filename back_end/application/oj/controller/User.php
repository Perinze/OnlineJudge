<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午2:03
 */

namespace app\oj\controller;

use app\oj\model\CommonModel;
use app\oj\model\UserModel;
use app\oj\validate\UserValidate;
use think\Controller;
use think\facade\Session;
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Request-Methods:*');
class User extends Controller
{

    // uncheck

    public function addUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $common_model = new CommonModel();
        $resp = $common_model->checkIdentity();
        if($resp['code'] !== CODE_SUCCESS){
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        $req = input('post.');

        $result = $user_validate->scene('foreAddUser')->check($req);
        if($result !== true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $req = $this->handleUserReq($req);

        $result = $user_validate->scene('addUser')->check($req);
        if($result !== true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $resp = $user_model->addUser($req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function editUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $user_id = Session::get('user_id');
        if(empty($user_id)){
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $req = input('post.');

        $result = $user_validate->scene('foreAddUser')->check($req);
        if($result !== true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $req = $this->handleUserReq($req);

        $result = $user_validate->scene('editUser')->check($req);
        if($result !== true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $resp = $user_model->editUser($user_id, $req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function deleteUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $common_model = new CommonModel();
        $resp = $common_model->checkIdentity();
        if($resp['code'] !== CODE_SUCCESS){
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        $req = input('post.');
        $result = $user_validate->scene('deleteUser')->check($req);
        if($result !== true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $resp = $user_model->deleUser($req['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function searchUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();

        $req = input('post.');
        $result = $user_validate->scene('searchUser_id')->check($req);
        if($result != true){
            $result = $user_validate->scene('searchUser_nick')->check($req);
            if($result != true){
                return apiReturn(CODE_ERROR, $user_validate->getError(), '');
            }
            $resp = $user_model->searchUserByNick($req['nick']);
        } else {
            $resp = $user_model->searchUserById($req['id']);
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    private function handleUserReq($req) {
        $req['desc'] = json_encode([
            'phone'=>$req['phone'],
            'sex'=>$req['sex'],
            'sign'=>$req['sign']
        ]);
        unset($req['phone'],$req['sex'],$req['sign']);
        return $req;
    }

    public function change_password()
    {
        $user_model = new UserModel();
        $user_validate = new UserValidate();
        if(session('find_password') !== true){
            return apiReturn(CODE_ERROR, '找回密码无效，请重新提交验证', '');
        }
        $req = input('post.');
        $result = $user_validate->scene('change_password')->check($req);
        if($result !== true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        if($req['password'] !== $req['password_check']){
            return apiReturn(CODE_ERROR, '两次输入密码不一致', '');
        }
        $user_id = Session::get('user_id');
        $resp = $user_model->editUser($user_id, array(
            'password' => md5(base64_encode($req['password']))
        ));
        Session::set('find_password', false);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}