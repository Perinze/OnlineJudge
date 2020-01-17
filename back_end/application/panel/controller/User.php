<?php


namespace app\panel\controller;


use app\oj\model\UserModel;

class User extends Base
{
    /* 接口 */
    /**
     * 添加用户
     */
    public function addUser()
    {

    }

    /**
     * 删除用户
     */
    public function deleUser()
    {

    }

    /**
     * 修改用户
     */
    public function editUser()
    {

    }

    /**
     * 查询所有用户
     */
    public function getAllUser()
    {
        $user_model = new UserModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'contest_name');
        $resp = $user_model->getAllUser($where['where'], $where['limit'], $where['offset']);
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $user_model);
    }

    /**
     * 查询单个用户信息
     */
    public function getTheUser()
    {

    }

    /* 页面 */
    /**
     * 添加用户页面
     */
    public function add()
    {

    }

    /**
     * 用户详情页面
     */
    public function info()
    {

    }

    /**
     * 首页
     */
    public function index()
    {
        return $this->fetch('index');
    }
}