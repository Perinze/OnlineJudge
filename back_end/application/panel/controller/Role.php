<?php

namespace app\panel\controller;

use app\panel\model\AuthorityModel;
use app\panel\model\RoleGroupModel;
use app\panel\model\UserModel;
use think\Controller;

class Role extends Base {
    public function test() {
        $model = new RoleGroupModel();
        $authModel = new AuthorityModel();
        $userModel = new UserModel();
        $data = [
            'nick' => 'lxh001',
            'role_group' => ['super'],
            'group_name' => ['']
        ];
        $result = $authModel->addAuthority(['name'=>'add']);
        return apiReturn(200, 'OK', $result);
    }
}