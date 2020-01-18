<?php


namespace app\panel\model;


use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $json = ['role_group'];

    public function getAllUser($where, $limit, $offset)
    {
        try{
            $field = ['user_id', 'nick', 'realname', 'school', 'major', 'class', 'identity', 'status'];
            $info = $this->field($field)
                ->where($where)
                ->limit($offset, $limit)
                ->withAttr('identity', function($value) {
                    $status = [-1=>'删除', 0=>'正常用户', 1=>'学生', 2=>'教师', 3=>'管理员'];
                    return $status[$value];
                })
                ->withAttr('status', function($value) {
                    $status = [-1=>'删除', 0=>'正常'];
                    return $status[$value];
                })
                ->select();
            if($info === false){
                return ['code' => CODE_ERROR,'msg' => '返回值异常','data' => $this->getError()];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取成功', 'data' => $info->toArray()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR,'msg' => '操作数据库异常','data' => $e->getMessage()];
        }
    }

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
                    if ($info['code'] == CODE_ERROR) {
                        return ['code' => CODE_ERROR, 'msg' => '有权限组不存在', 'data' => $group];
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
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '用户不存在', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
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
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
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
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $msg['role_group']];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '用户不存在', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
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
            return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => []];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

}