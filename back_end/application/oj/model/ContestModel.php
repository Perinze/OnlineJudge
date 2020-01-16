<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午12:47
 */

namespace app\oj\model;

use think\Exception;
use think\Model;

class ContestModel extends Model
{

    // uncheck

    protected $table = 'contest';

    public function searchContest($contest_id = 0, $contest_name = '')
    {
        try {
            if ($contest_id === 0 && $contest_name === '') {
                $content = $this->where('status', '<>', 0)->select()->toArray();
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
            } else if ($contest_id !== 0) {
                $content = $this->where('contest_id', $contest_id)->find();
                if (empty($content)) {
                    return ['code' => CODE_ERROR, 'msg' => '未找到数据', 'data' => ''];
                }
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
            } else {
                $content = $this->where('contest_name', 'like', '%' . $contest_name . '%')->select()->toArray();
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function newContest($data)
    {
        try {
            $res = $this->insert($data);
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '新建比赛成功', 'data' => ''];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '新建比赛失败', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function deleContest($contest_id)
    {
        try {
            $res = $this->where('contest_id', $contest_id)->update(['state' => 0]);
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '删除比赛成功', 'data' => ''];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '删除比赛失败', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function editContest($contest_id, $data)
    {
        try {
            $res = $this->where('contest_id', $contest_id)->update($data);
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '编辑比赛成功', 'data' => ''];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '编辑比赛失败', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function getAllContest($where, $limit, $offset)
    {
        try{
            $field = ['contest_id', 'contest_name', 'begin_time', 'end_time', 'status'];
            $info = $this->field($field)
                ->where($where)
                ->limit($offset, $limit)
                ->select();
            if($info === false){
                return ['code' => CODE_ERROR,'msg' => '返回值异常','data' => $this->getError()];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取成功', 'data' => $info->toArray()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR,'msg' => '操作数据库异常','data' => $e->getMessage()];
        }
    }
}