<?php

namespace app\panel\model;

use think\Db;
use think\Model;
use think\exception\DbException;

class UserModel extends Model {
    protected $table = 'users';
    protected $json = ['role_group'];

    /**
     * @usage 为用户更新权限组
     * @param array $data ['nick', 'role_group']
     * @return array ['code', 'msg', 'data']
     */
    public function updateRoleGroup($data) {
        try {
            $roleGroupModel = new RoleGroupModel();
            $where = ['nick' => $data['nick']];
            $msg = $this->where($where)->find();
            if ($msg) {
                $groups = $this->getRoleGroups($data)['data']->group;
                if ($groups != null) {
                    //删除现有权限组的注册
                    foreach ($groups as $group) {
                        $roleGroupModel->decUserNumber($group);
                    }
                }
                //判断权限组是否存在
                foreach ($data['role_group'] as $group) {
                    $info = $roleGroupModel->getRoleGroup($group);
                    if ($info['code'] == -1) {
                        return ['code' => -1, 'msg' => '有权限组不存在', 'data' => $group];
                    }
                }
                //注册新的权限组
                foreach ($data['role_group'] as $group) {
                    $roleGroupModel->incUserNumber($group);
                }
                $insertData = [
                    'role_group' => ['group' => $data['role_group']],
                ];
                $result = $this->where($where)->update($insertData);
                return ['code' => 1, 'msg' => '更新成功', 'data' => $result];
            } else {
                return ['code' => -1, 'msg' => '用户不存在', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => -1, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 查找某项权限
     * @param string $nick
     * @param string $auth
     * @return boolean|array ['code', 'msg', 'data']
     */
    public function existAuthority($nick, $auth) {
        try {
            $groupModel = new RoleGroupModel();
            $groups = $this->getRoleGroups(['nick'=>$nick])['data']->group;
            foreach ($groups as $group) {
                //寻找每个权限组内权限
                $authorities = $groupModel->getRoleGroup($group)['data']['authority']->auth;
                foreach ($authorities as $authority) {
                    if ($authority == $auth) {
                        return true;
                    }
                }
            }
            return false;
        } catch (DbException $e) {
            return ['code' => -1, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获得所有权限
     * @param array $data ['nick']
     * @return array ['code', 'msg', 'data']
     */
    public function getRoleGroups($data) {
        try {
            $where = ['nick' => $data['nick']];
            $msg = $this->where($where)->find();
            if ($msg) {
                return ['code' => -1, 'msg' => '查找成功', 'data' => $msg['role_group']];
            } else {
                return ['code' => -1, 'msg' => '用户不存在', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => -1, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除某权限组在用户中的注册
     * @param string $group_name
     * @return array ['code', 'msg', 'data']
     */
    public function deleteUserRoleGroup($group_name) {
        try {
            //获取json字段中存在需要删除权限组的数据
            $sql = "select * from users where role_group->'$.group' like  \"%".$group_name."%\";";
            $result = Db::query($sql);
            if ($result != null) {
                foreach ($result as $user) {
                    $nick = $user['nick'];
                    $role_group = $this->getRoleGroups(['nick' => $nick])['data']->group;
                    //构造新的权限字段
                    $new_role_group = new \ArrayObject();
                    foreach ($role_group as $group) {
                        if ($group != $group_name) {
                            $new_role_group->append($group);
                        }
                    }
                    if ($new_role_group->count() == 0) {
                        $new_role_group->append('guest');
                    }
                    //更新权限组
                    $data = [
                        'nick' => $nick,
                        'role_group' => (array)$new_role_group,
                    ];
                    $this->updateRoleGroup($data);
                }
            }
            return ['code' => 1, 'msg' => '删除成功', 'data' => []];
        } catch (DbException $e) {
            return ['code' => -1, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

}