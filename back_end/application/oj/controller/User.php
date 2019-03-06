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

    // uncheck

    public function addUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $req = input('post.');

        $result = $user_validate->scene('foreAddUser')->check($req);
        if($result != true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $req = $this->handleUserReq($req);

        $result = $user_validate->scene('addUser')->check($req);
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

        $user_id = $req['user_id'];
        unset($req['user_id']);

        $result = $user_validate->scene('foreAddUser')->check($req);
        if($result != true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $req = $this->handleUserReq($req);

        $result = $user_validate->scene('editUser')->check($req);
        if($result != true){
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $resp = $user_model->editUser($user_id, $req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function deleteUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();

        $req = input('post.');
        $result = $user_validate->scene('deleteUser')->check($req);
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
}