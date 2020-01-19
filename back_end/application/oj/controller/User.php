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
    /**
     * 用户信息更新
     */
    public function editUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();
        $oj_cache_model = new OJCacheModel();

        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        // 是否有更新限制
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

        // edit
        $data = $user['data'];
        $resp = $user_model->editUser($user_id, [
            'user_id' => $user_id,
            'realname' => isset($req['realname']) ? $req['realname'] : $data['realname'],
            'school' => isset($req['school']) ? $req['school'] : $data['school'],
            'contact' => isset($req['contact']) ? $req['contact'] : $data['contact'],
            'major' => isset($req['major']) ? $req['major'] : $data['major'],
            'class' => isset($req['class']) ? $req['class'] : $data['class'],
            'desc' => isset($req['desc']) ? $req['desc'] : $data['desc'],
        ]);
        // 更新时间间隔
        $oj_cache_model->set_update_cache($user_id);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 模糊查询用户
     */
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

    /**
     * 忘记密码后修改密码操作
     */
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

        // check code
        $info = $find_password_model->check_token($req['nick'], $req['check']);
        if($info['code'] !== CODE_SUCCESS){
            return apiReturn(CODE_ERROR, '修改失败', '');
        }
        if ($req['password'] !== $req['password_check']) {
            return apiReturn(CODE_ERROR, '两次输入密码不一致', '');
        }

        // update
        $resp = $user_model->editUser(array(
            'password' => md5(base64_encode($req['password']))
        ), $req['nick']);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 更换密码
     */
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
        // 原密码校验
        $info = $user_model->loginCheck(['nick' => $req['nick'], 'password' => md5(base64_encode($req['old_password']))]);
        if($info['code'] !== CODE_SUCCESS){
            return apiReturn($info['code'], $info['msg'], '');
        }
        // 两次密码校验
        if($req['password'] !== $req['password_check']){
            return apiReturn(CODE_ERROR, '两次输入密码不一致', '');
        }
        $resp = $user_model->editUser($user_id, array(
            'password' => md5(base64_encode($req['password']))
        ));

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}