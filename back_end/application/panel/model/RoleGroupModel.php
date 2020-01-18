<?php

namespace app\panel\model;

use think\Exception;
use think\exception\DbException;
use think\Model;

class RoleGroupModel extends Model {
    protected $table = 'role_group';
    protected $json = ['authority'];

    /**
     * @usage 获取所有权限组
     * @param void
     * @return array ['code', 'msg', 'data']
     */
    public function getAllGroup() {
        try {
            $msg = $this->select();
            foreach ($msg as $item) {
                $item['authority'] = $item['authority']->auth;
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $msg];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取某权限组
     * @param string $group_name
     * @return array ['code', 'msg', 'data']
     */
    public function getRoleGroup($group_name) {
        try {
            $where = ['group_name' => $group_name];
            $msg = $this->where($where)->find();
            if ($msg) {
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $msg];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 添加权限组
     * @param array $data ['group_name']
     * @return array ['code', 'msg', 'data']
     */
    public function addRoleGroup($data) {
        try {
            $where = ['group_name' => $data['group_name']];
            $msg = $this->where($where)->find();
            if ($msg) {
                return ['code' => CODE_ERROR, 'msg' => '权限组已存在', 'data' => $msg];
            } else {
                //默认权限组不存在权限
                $insertData = [
                    'group_name' => $data['group_name'],
                    'authority' => ["auth" => []],
                ];
                $info = $this->insertGetId($insertData);
                return ['code' => CODE_SUCCESS, 'msg' => '插入成功', 'data' => $info];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除权限组
     * @param array $data ['group_name']
     * @return array ['code', 'msg', 'data']
     */
    public function deleteRoleGroup($data) {
        try {
            $role_group = $this->getRoleGroup($data['group_name']);
            if ($role_group['code'] == CODE_ERROR) {
                return ['code' => CODE_ERROR, 'msg' => '数据库异常或用户组不存在', 'data' => []];
            } else if ($role_group['data']['user_num'] !== 0) {
                //需要考虑删除权限组时用户注册的权限组情况
                return ['code' => CODE_ERROR, 'msg' => '有用户绑定于此权限', 'data' => $role_group];
            } else {
                $result = $this->where(['group_name' => $data['group_name']])->delete();
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => $result];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 更新权限
     * @param array $data ['group_name', 'authority']
     * @return array ['code', 'msg', 'data']
     */
    public function updateAuthority($data) {
        try {
            $authModel = new AuthorityModel();
            //验证权限是否存在
            foreach ($data['authority'] as $auth) {
                $info = $authModel->getAuthority($auth);
                if ($info['code'] == -1) {
                    return ['code' => CODE_ERROR, 'msg' => '有权限不存在', 'data' => $auth];
                }
            }
            $where = ['group_name' => $data['group_name']];
            $msg = $this->where($where)->find();
            if ($msg) {
                $insertData = [
                    'authority' => ['auth' => $data['authority']],
                ];
                $result = $this->where($where)->update($insertData);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '权限组不存在', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 启用/禁用权限组
     * @param string $group_name
     * @return array ['code', 'msg', 'data']
     */
    public function switchRoleGroupStatus($group_name) {
        try {
            $where = ['group_name' => $group_name];
            $msg = $this->where($where)->find();
            if ($msg) {
                if ($msg['enabled'] == 1) {
                    return $this->disableRoleGroup($group_name);
                } else {
                    return $this->enableRoleGroup($group_name);
                }
            } else {
                return ['code' => CODE_ERROR, 'msg' => '不存在此权限', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }


    /**
     * @usage 启用权限组
     * @param string $group_name
     * @return array ['code', 'msg', 'data']
     */
    public function enableRoleGroup($group_name) {
        try {
            $where = ['group_name' => $group_name];
            $msg = $this->where($where)->find();
            if ($msg) {
                $result = $this->where($where)->update(['enabled' => 1]);
                return ['code' => CODE_SUCCESS, 'msg' => '启用成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '不存在此权限组', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 停用权限组
     * @param string $group_name
     * @return array ['code', 'msg', 'data']
     */
    public function disableRoleGroup($group_name) {
        try {
            $where = ['group_name' => $group_name];
            $msg = $this->where($where)->find();
            if ($msg) {
                $result = $this->where($where)->update(['enabled' => 0]);
                return ['code' => CODE_SUCCESS, 'msg' => '停用成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '不存在此权限组', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 用户加一
     * @param string $group_name
     * @return array ['code', 'msg', 'data']
     */
    public function incUserNumber($group_name) {
        try {
            $where = ['group_name' => $group_name];
            $msg = $this->where($where)->find();
            if ($msg) {
                $result = $this->where($where)->setInc('user_num');
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '不存在此权限组', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 用户数减一
     * @param string $group_name
     * @return array ['code', 'msg', 'data']
     */
    public function decUserNumber($group_name) {
        try {
            $where = ['group_name' => $group_name];
            $msg = $this->where($where)->find();
            if ($msg) {
                $result = $this->where($where)->setDec('user_num');
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '不存在此权限组', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}
