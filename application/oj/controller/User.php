<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午2:03
 */

namespace app\oj\controller;


use app\oj\model\UserModel;
use app\oj\validate\UserValidate;

class User extends Base
{
    public function addUser()
    {
        // TODO fix bugs
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $req = input('post.');
        $result = $user_validate->scene('adduser')->check($req);
        if($result != true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $resp = $user_model->addUser($req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function editUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $req = input('post.');
        $result = $user_validate->scene('edituser')->check($req);
        if($result != true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $resp = $user_model->editUser($req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function deleteUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $req = input('post.');
        $result = $user_validate->scene('deleteuser')->check($req);
        if($result != true){
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
        $result = $user_validate->scene('searchuser_id')->check($req);
        if($result != true){
            $result = $user_validate->scene('searchuser_nick')->check($req);
            if($result != true){
                return apiReturn(CODE_ERROR, $user_validate->getError(), '');
            }
            $resp = $user_model->searchUserByNick($req['nick']);
        } else {
            $resp = $user_model->searchUserById($req['id']);
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}