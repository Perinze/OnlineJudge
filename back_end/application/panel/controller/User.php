<?php


namespace app\panel\controller;


use app\oj\validate\UserValidate;
use app\panel\model\UserModel;

class User extends Base
{
    /* 接口 */
    /**
     * 添加用户
     */
    public function addUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();

        $req = input('post.');
        $result = $user_validate->scene('addUser')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }

        $user = $user_model->searchUserByNick($req['nick']);
        if($user['code'] === CODE_SUCCESS){
            return apiReturn(CODE_ERROR, '已有用户', '');
        }

        // add
        $req['password'] = md5(base64_encode($req['password']));
        $req['role_group'] = json_encode(array());
        $resp = $user_model->addUser($req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    /**
     * 删除用户
     */
    public function deleteUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();

        $req = input('post.');
        $result = $user_validate->scene('deleteUser')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }

        $resp = $user_model->deleUser($req['id']);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 修改用户
     */
    public function editUser()
    {
        $user_validate = new UserValidate();
        $user_model = new UserModel();

        $req = input('post.');
        $result = $user_validate->scene('editUser')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $user_validate->getError(), '');
        }

        $user = $user_model->searchUserById($req['user_id']);
        if($user['code'] !== CODE_SUCCESS){
            return apiReturn($user['code'], $user['msg'], '');
        }

        // edit
        $resp = $user_model->editUser($req['user_id'], $req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 查询所有用户
     */
    public function getAllUser()
    {
        $user_model = new UserModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'nick');
        $resp = $user_model->getAllUser($where['where'], $where['limit'], $where['offset']);
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $user_model);
    }

    /**
     * 查询单个用户信息
     */
    public function getTheUser()
    {
        $user_model = new UserModel();

        $req = input('post.');
        if(!isset($req['user_id'])){
            return apiReturn(CODE_ERROR, '未填写用户id', '');
        }
        $user = $user_model->searchUserById($req['user_id']);

        return apiReturn($user['code'], $user['msg'], $user['data']);
    }

    /* 页面 */
    /**
     * 添加用户页面
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 用户详情页面
     */
    public function info()
    {
        $req = input('get.');
        $id = isset($req['id']) ? $req['id'] : 0;
        $this->assign('id', $id);
        return $this->fetch();
    }

    /**
     * 首页
     */
    public function index()
    {
        return $this->fetch();
    }
}