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
     */
    public function get_all_group()
    {
        $group_model = new GroupModel();
        $req = input('post.');
        $resp = $group_model->get_all_group(isset($req['page']) ? $req['page'] : 0);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 获取一个用户加入的所有团队
     */
    public function user_get_all_group()
    {
        $usergroup_model = new UsergroupModel();
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $req = input('post.');
        $resp = $usergroup_model->find_group($session, isset($req['page']) ? $req['page'] : 0);
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
        $user_id = isset($req['user_id']) ? $req['user_id'] : array();
        if(!is_array($user_id)){
            return apiReturn(CODE_ERROR, '添加用户格式错误', '');
        }
        $resp = $group_model->newGroup(array(
            'group_name' => $req['group_name'],
            'avatar' => isset($req['avatar']) ? $req['avatar'] : '',
            'desc' => $req['desc'],
            'join_code' => isset($req['join_code']) ?  strlen($req['join_code']) > 16 ? substr($req['join_code'], 0, 16) : $req['join_code'] : '',
            'group_creator' => $session,
        ), $user_id);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 加入一个团队
     */
    public function join_group()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();
        $group_model = new GroupModel();
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
        $join_code = $group_model->get_the_group($req['group_id']);
        if($join_code['code'] !== CODE_SUCCESS){
            return apiReturn($join_code['code'], $join_code['msg'], $join_code['data']);
        }
        if($join_code['data']['join_code'] !== $req['join_code']){
            return apiReturn(CODE_ERROR, '加群码错误', '');
        }
        $resp = $usergroup_model->addRelation($req['group_id'], $session, 0);
        if(strpos($resp['data'], 'Duplicate entry') !== false){
            $resp['msg'] = '已在群组内';
            $resp['data'] = '';
        }
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
        $resp = $usergroup_model->addRelation($req['group_id'], $req['user_id'], 0);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}