<?php

namespace app\common\model;


use think\Exception;
use think\exception\DbException;
use think\Model;
use app\oj\model\OJCacheModel;
class NotificationModel extends Model
{
    protected $table = 'notification';

    public function getAllNotification($where, $limit, $offset)
    {
        try{
            $field = ['id', 'title', 'content', 'submit_time', 'modify_time', 'contest_id', 'user_id', 'status'];
            $info = $this->field($field)
                ->where($where)
                ->limit($offset, $limit)
                ->withAttr('status', function($value) {
                    $status = [0=>'不可用', 1=>'可用'];
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

    public function getNotificationByID($id) {
        try {
            $info = $this
                ->field(['id', 'title', 'content', 'submit_time', 'modify_time', 'user_id', 'status'])
                ->where(['id' => $id])->find();
            if (!$info) {
                return ['code' => CODE_ERROR, 'msg' => 'id不存在', 'data' => ''];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function getNotificationByContest($contest_id) {
        $OJCacheModel = new OJCacheModel();
        $cache = $OJCacheModel->get_contest_notification_cache($contest_id);
        if ($cache['code'] == CODE_SUCCESS) {
            return ['code' => $cache['code'], 'msg' => '查询成功', 'data' => $cache['data']];
        }
        try {
            $where = ['contest_id' => $contest_id];
            $info = $this
                ->field(['id', 'title', 'content', 'submit_time', 'modify_time', 'user_id'])
                ->where($where)->where(['status' => 1])->select();
            if (!$info) {
                return ['code' => CODE_ERROR, 'msg' => 'id不存在', 'data' => ''];
            } else {
                $OJCacheModel->set_contest_notification_cache($contest_id, $info);
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function getPublicNotification() {
        $OJCacheModel = new OJCacheModel();
        $cache = $OJCacheModel->get_public_notification_cache();
        if ($cache['code'] == CODE_SUCCESS) {
            return ['code' => $cache['code'], 'msg' => '查询成功', 'data' => $cache['data']];
        }
        try {
            $where = ['contest_id' => null];
            $info = $this
                ->field(['id', 'title', 'content', 'submit_time', 'modify_time', 'user_id'])
                ->where($where)->where(['status' => 1])->select();
            if (!$info) {
                return ['code' => CODE_ERROR, 'msg' => 'id不存在', 'data' => ''];
            } else {
                $OJCacheModel->set_public_notification_cache($info);
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }


    public function addNotification($data) {
        try {
            $info = $this->insert($data);
            if ($info === false) {
                return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => ''];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function modifyNotification($id, $data) {
        try{
            $info = $this->where('id', $id)->update($data);
            if ($info !== 0) {
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
            }
            return ['code' => CODE_ERROR, 'msg' => '更新失败', 'data' => ''];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function deleteNotification($id) {
        try{
            $info = $this->where('id', $id)->delete();
            if ($info !== 0) {
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => $info];
            }
            return ['code' => CODE_ERROR, 'msg' => '删除失败', 'data' => ''];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function changeNotificationStatus($id) {
        try {
            $where = ['id' => $id];
            $info = $this->where($where)->find();
            if (!$info) {
                return ['code' => CODE_ERROR, 'msg' => 'id不存在', 'data' => ''];
            } else {
                $res = $this->where($where)->update(['status' => 1-$info['status']]);
                if ($res !== 0) {
                    return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
                }
                return ['code' => CODE_ERROR, 'msg' => '更新失败', 'data' => ''];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}