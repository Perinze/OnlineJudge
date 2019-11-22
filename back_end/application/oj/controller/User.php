<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午2:03
 */

namespace app\oj\controller;

use app\common\model\FindPasswordModel;
use app\oj\model\CommonModel;
use app\oj\model\OJCacheModel;
use app\oj\model\UserModel;
use app\oj\validate\UserValidate;
use think\Controller;
use think\facade\Session;


class User extends Controller
{

    // uncheck

    public function addUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $common_model = new CommonModel();
        $resp = $common_model->checkIdentity();
        if ($resp['code'] !== CODE_SUCCESS) {
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        $req = input('post.');

        $result = $user_validate->scene('foreAddUser')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $req = $this->handleUserReq($req);

        $result = $user_validate->scene('addUser')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $resp = $user_model->addUser($req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function editUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $oj_cache_model = new OJCacheModel();
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $data = $oj_cache_model->get_update_cache($user_id);
        if($data['code'] === CODE_SUCCESS){
            return apiReturn(CODE_ERROR, '请不要频繁更新， 更新时间为1天','');
        }
        $req = input('post.');

        $result = $user_validate->scene('editUser')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $user = $user_model->searchUserById($user_id);
        if($user['code'] !== CODE_SUCCESS){
            return apiReturn($user['code'], $user['msg'], '');
        }
        $data = $user['data'];
        $resp = $user_model->editUser($user_id, [
            'user_id' => $user_id,
            'realname' => isset($req['realname']) ? $req['realname'] : $data['realname'],
            'school' => isset($req['school']) ? $req['school'] : $data['school'],
            'major' => isset($req['major']) ? $req['major'] : $data['major'],
            'class' => isset($req['class']) ? $req['class'] : $data['class'],
            'desc' => isset($req['desc']) ? $req['desc'] : $data['class'],
        ]);
        $oj_cache_model->set_update_cache($user_id);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function deleteUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $common_model = new CommonModel();
        $resp = $common_model->checkIdentity();
        if ($resp['code'] !== CODE_SUCCESS) {
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        $req = input('post.');
        $result = $user_validate->scene('deleteUser')->check($req);
        if ($result !== true) {
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
        if ($result != true) {
            $result = $user_validate->scene('searchUser_nick')->check($req);
            if ($result != true) {
                return apiReturn(CODE_ERROR, $user_validate->getError(), '');
            }
            $resp = $user_model->searchUserByNick($req['nick']);
        } else {
            $resp = $user_model->searchUserById($req['user_id']);
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function forget_password()
    {
        $user_model = new UserModel();
        $user_validate = new UserValidate();
        $find_password_model = new FindPasswordModel();
        $req = input('post.');
        $result = $user_validate->scene('forget_password')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $info = $find_password_model->check_token($req['nick'], $req['check']);
        if($info['code'] !== CODE_SUCCESS){
            return apiReturn(CODE_ERROR, '修改失败', '');
        }
        if ($req['password'] !== $req['password_check']) {
            return apiReturn(CODE_ERROR, '两次输入密码不一致', '');
        }
        $resp = $user_model->editUser(array(
            'password' => md5(base64_encode($req['password']))
        ), $req['nick']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function change_password()
    {
        $user_model = new UserModel();
        $user_validate = new UserValidate();
        $user_id = Session::get('user_id');
        if(empty($user_id)){
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $req = input('post.');
        $result = $user_validate->scene('change_password')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }
        $info = $user_model->loginCheck(['nick' => $req['nick'], 'password' => md5(base64_encode($req['old_password']))]);
        if($info['code'] !== CODE_SUCCESS){
            return apiReturn($info['code'], $info['msg'], '');
        }
        if($req['password'] !== $req['password_check']){
            return apiReturn(CODE_ERROR, '两次输入密码不一致', '');
        }
        $resp = $user_model->editUser($user_id, array(
            'password' => md5(base64_encode($req['password']))
        ));
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}