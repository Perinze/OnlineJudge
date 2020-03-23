<?php

namespace app\panel\controller;

use app\panel\model\AuthorityModel;
use app\panel\model\RoleGroupModel;
use app\panel\model\UserModel;
use think\Controller;

class Role extends Base {

    /**
     * 获取所有权限组
     */
    public function getAllRoleGroup() {
        $role_group_model = new RoleGroupModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'group_name');
        $resp = $role_group_model->getAllGroup();
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $role_group_model);
    }

    /*
     * 添加权限组
     */
    public function addRoleGroup() {
        $group_name = input('get.group_name');
        $role_group_model = new RoleGroupModel();
        $msg = $role_group_model->addRoleGroup(['group_name' =>$group_name]);
        return apiReturn($msg['code'], $msg['msg'], $msg['data'], 200);
    }

    /*
     * 删除权限组
     */
    public function deleteRoleGroup() {
        $group_name = input('get.group_name');
        $role_group_model = new RoleGroupModel();
        $role_group_model->deleteRoleGroup(['group_name' =>$group_name]);
        $this->redirect("/back_end/panel/role/index");
    }
    /*
     * 更新权限组
     */
    public function updateRoleGroup() {
        $group_name = input('post.group_name');
        $authorities = input('post.authorities');
        $role_group_model = new RoleGroupModel();
        $where = [
            "group_name" => $group_name,
            "authority" => (array)$authorities
        ];
        $msg = $role_group_model->updateAuthority($where);
        return apiReturn($msg['code'], $msg['msg'], $msg['code'], 200);
    }

    /*
     * 更改权限组状态
     */
    public function switchGroupStatus() {
        $auth = input('get.group_name');
        $authority_model = new RoleGroupModel();
        $msg = $authority_model->switchRoleGroupStatus($auth);
        $this->redirect("/back_end/panel/role/index");
    }

    /*
     * 获取所有权限
     */
    public function getAllAuthority() {
        $authority_model = new AuthorityModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'name');
        $resp = $authority_model->getAllAuthority();
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $authority_model);
    }

    public function addAuthority() {
        $auth = input('get.auth');
        $authority_model = new AuthorityModel();
        $msg = $authority_model->addAuthority(['name' => $auth]);
        return apiReturn($msg['code'], $msg['msg'], $msg['data'], 200);
    }

    public function deleteAuthority() {
        $auth = input('get.auth');
        $authority_model = new AuthorityModel();
        $msg = $authority_model->deleteAuthority($auth);
        $this->redirect("/back_end/panel/role/auth");
    }

    public function switchAuthorityStatus() {
        $auth = input('get.auth');
        $authority_model = new AuthorityModel();
        $msg = $authority_model->switchAuthority($auth);
        $this->redirect("/back_end/panel/role/auth");
    }

    public function edit() {
        $group_name = input('get.group_name');
        $role_group_model = new RoleGroupModel();
        $authority_model = new AuthorityModel();
        $data = $role_group_model->getRoleGroup($group_name)['data'];
        $authorities = $authority_model->getAuthorities(['enabled' => 1])['data'];
        foreach ($authorities as $authority) {
            if (in_array($authority['name'], $data['authority']->auth)) {
                $authority['checked'] = 'checked';
            } else {
                $authority['checked'] = '';
            }
        }
        $returnData = [
            'name' => $data['group_name'],
            'auth' => $authorities
        ];
        return $this->fetch('', $returnData);
    }

    public function auth() {
        return $this->fetch();
    }

    public function index() {
        return $this->fetch();
    }
}