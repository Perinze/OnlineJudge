<?php
namespace app\panel\model;

use think\Db;
use think\exception\DbException;
use think\Model;

class AuthorityModel extends Model {
    protected $table = 'authority';

    /**
     * @usage 获取所有权限
     * @param void
     * @return array ['code', 'msg', 'data']
     */
    public function getAllAuthority() {
        try {
            $msg = $this->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $msg];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取权限
     * @param array $where
     * @return array ['code', 'msg', 'data']
     */
    public function getAuthorities($where) {
        try {
            $msg = $this->where($where)->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $msg];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
    /**
     * @usage 获取权限
     * @param string $name
     * @return array ['code', 'msg', 'data']
     */
    public function getAuthority($name) {
        try {
            $where = ['name' => $name];
            $msg = $this->where($where)->find();
            if ($msg) {
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $msg];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_SUCCESS, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 添加权限
     * @param array $data['name']
     * @return  array ['code', 'msg', 'data']
     */
    public function addAuthority($data) {
        try {
            if ($data == "") {
                return ['code' => CODE_ERROR, 'msg' => '空权限', 'data' => []];
            }
            $where = ['name' => $data['name']];
            $msg = $this->where($where)->find();
            if ($msg) {
                return ['code' => CODE_ERROR, 'msg' => '已有此权限', 'data' => $msg];
            } else {
                $info = $this->insertGetId($data);
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => $info];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除权限
     * @param string $name
     * @return array ['code', 'msg', 'data']
     */
    public function deleteAuthority($name) {
        try {
            $groupModel = new RoleGroupModel();
            //获取json字段中存在name的数据
            $sql = "select * from role_group where authority->'$.auth' like  \"%".$name."%\";";
            $result = Db::query($sql);
            if ($result != null) {
                foreach ($result as $group) {
                    $group_name = $group['group_name'];
                    $authorities = json_decode($group['authority'])->auth;
                    //构件新的authorities字段
                    $new_authorities = new \ArrayObject();
                    foreach ($authorities as $authority) {
                        if ($authority != $name) {
                            $new_authorities->append($authority);
                        }
                    }
                    //更新权限组
                    $data = [
                        'group_name' => $group_name,
                        'authority' => (array)$new_authorities
                    ];
                    $groupModel->updateAuthority($data);
                }
                $where = ['name' => $name];
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => []];
            } else {
                $msg = $this->where(['name' => $name])->delete();
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 启用/禁用权限
     * @param string $name
     * @return array ['code', 'msg', 'data']
     */
    public function switchAuthority($name) {
        try {
            $where = ['name' => $name];
            $msg = $this->where($where)->find();
            if ($msg) {
                if ($msg['enabled'] == 1) {
                    return $this->disableAuthority($name);
                } else {
                    return $this->enableAuthority($name);
                }
            } else {
                return ['code' => CODE_ERROR, 'msg' => '不存在此权限', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 启用权限
     * @param string $name
     * @return array ['code', 'msg', 'data']
     */
    public function enableAuthority($name) {
        try {
            $where = ['name' => $name];
            $msg = $this->where($where)->find();
            if ($msg) {
                $result = $this->where($where)->update(['enabled' => 1]);
                return ['code' => CODE_SUCCESS, 'msg' => '启用成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '不存在此权限', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 关闭权限
     * @param string $name
     * @return array ['code', 'msg', 'data']
     */
    public function disableAuthority($name) {
        try {
            $where = ['name' => $name];
            $msg = $this->where($where)->find();
            if ($msg) {
                $result = $this->where($where)->update(['enabled' => 0]);
                return ['code' => CODE_SUCCESS, 'msg' => '启用成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '不存在此权限', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

}