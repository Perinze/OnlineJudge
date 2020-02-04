<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 15:33
 */

namespace app\oj\controller;

use app\oj\model\GroupModel;
use app\oj\model\UsergroupModel;
use app\oj\validate\GroupValidate;
use think\Controller;
use think\facade\Session;


class Group extends Controller
{

    // uncheck
    /**
     * 获取所有团队
     * TODO 分页返回
     */
    public function get_all_group()
    {
        $group_model = new GroupModel();
        $resp = $group_model->get_all_group();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 获取一个用户加入的所有团队
     * TODO 分页返回
     */
    public function user_get_all_group()
    {
        $usergroup_model = new UsergroupModel();
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $resp = $usergroup_model->find_group($session);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 获取某个团队的基本信息
     */
    public function get_the_group()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();
        $group_model = new GroupModel();

        $req = input('post.');
        $result = $group_validate->scene('get_the_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $resp = $usergroup_model->find_user($req['group_id']);// find all users who joined this group
        $resp1 = $group_model->get_the_group($req['group_id']);// get this group's info
        return apiReturn($resp['code'], $resp['msg'], array(
            'user' => $resp['data'],
            'group' => $resp1['data']
        ));
    }

    /**
     * 添加一个团队
     * TODO 限制一个用户可创建团队数目
     */
    public function add_group()
    {
        $group_validate = new GroupValidate();
        $group_model = new GroupModel();

        // check login
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        // add
        $req = input('post.');
        $result = $group_validate->scene('add_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $resp = $group_model->newGroup(array(
            'group_name' => $req['group_name'],
            'desc' => $req['desc'],
            'group_creator' => $req['group_creator'],
        ));
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 加入一个团队
     */
    public function join_group()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();
        $session = Session::get('user_id');

        // check login
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $req = input('post.');
        $result = $group_validate->scene('join_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        // TODO 申请逻辑，若无需审核直接添加，若需审核，加入提醒数据表
        $resp = 0;
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 退出团队
     */
    public function out_group()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();

        // check login
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        $req = input('post.');
        $result = $group_validate->scene('out_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $resp = $usergroup_model->deleRelation($req['group_id'], $session['user_id']);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 管理员同意一个用户的加入申请
     */
    public function accept()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();
        $group_model = new GroupModel();

        // check login
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        $req = input('post.');
        $result = $group_validate->scene('accept_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $resp = $group_model->get_the_group($req['group_id']);
        if ($resp['code'] !== CODE_SUCCESS) {
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        if ($resp['data']['group_creator'] !== $session['user_id']) {// TODO 团队管理员权限
            return apiReturn(CODE_ERROR, '你没有权限', '');
        }
        $resp = $usergroup_model->addRelation($req['group_id'], $req['user_id']);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}