<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/11/6
 * Time: 13:31
 */
namespace app\admin\model;

use think\Model;

class FeedbackModel extends Model
{
    protected $table = 'feedback';

    public function get_all_list()
    {
        try {
            $info = $this->where([['del', '=', 0], ['status' ,'=' , 0]])->field('id, title, time, type, status')->select()->toArray();
            if (empty($info)) {
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $this->getError()];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function get_the_list($where)
    {
        try {
            $info = $this->where($where)->find();
            if (empty($info)) {
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $this->getError()];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
            }
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function get_delete_item()
    {
        try {
            $info = $this->where('del', 1)->select()->toArray();
            if (empty($info)) {
                return ['code' => CODE_ERROR, 'msg' => '获取失败', 'data' => $this->getError()];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '获取成功', 'data' => $info];
            }
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function delete_item($id)
    {
        try {
            $info = $this->update(['del' => 1, 'id' => $id]);
            if (empty($info)) {
                return ['code' => CODE_ERROR, 'msg' => '删除失败', 'data' => $this->getError()];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => $info];
            }
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function recover_item($id)
    {
        try {
            $info = $this->update(['del' => 1, 'id' => $id]);
            if (empty($info)) {
                return ['code' => CODE_ERROR, 'msg' => '恢复失败', 'data' => $this->getError()];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '恢复成功', 'data' => $info];
            }
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

}