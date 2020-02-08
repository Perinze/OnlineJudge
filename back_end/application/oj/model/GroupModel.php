<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 16:08
 */

namespace app\oj\model;

use think\Db;
use think\Exception;
use think\Model;

class GroupModel extends Model
{
    protected $table = 'group';

    public function get_all_group($page)
    {
        try {
            $page_limit = config('wutoj_config.page_limit');
            $info['data'] = $this
                ->field(['group_id', 'group_name', 'group_creator', 'desc'])
                ->where('status', 0)
                ->limit($page * $page_limit, $page_limit)
                ->select()
                ->toArray();
            if (empty($info['data'])) {
                return ['code' => CODE_ERROR, 'msg' => '分组不存在', 'data' => $this->getError()];
            }
            $info['count'] = count($info['data']);
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    public function get_the_group($group_id)
    {
        try {
            $info = $this->where([['group_id', '=', $group_id], ['status', '=', 0]])->find();
            if (empty($info)) {
                return ['code' => CODE_ERROR, 'msg' => '分组不存在', 'data' => $this->getError()];
            }
            $info['count'] = Db::table('user_group')->where('group_id', $group_id)->count();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @param $data
     * @return array $data : $group_name $desc $group_creator
     */
    public function newGroup($data, $user_id)
    {
        try {
            $res = $this->insertGetId($data);
            if ($res) {
                $usergroup_model = new UsergroupModel();
                $resp = $usergroup_model->addRelation($res, $data['group_creator'], 2);
                foreach ($user_id as $item){
                    $resp = $usergroup_model->addRelation($res, $item['user_id'], (int)($item['identity'] === 1));
                }
                if ($resp['code'] !== CODE_SUCCESS) {
                    return ['code' => CODE_ERROR, 'msg' => '创建分组失败', 'data' => ''];
                }
                return ['code' => CODE_SUCCESS, 'msg' => '创建分组成功', 'data' => $res];
            }
            return ['code' => CODE_ERROR, 'msg' => '创建分组失败', 'data' => $this->getError()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function editGroup($group_id, $data)
    {
        try {
            $res = $this->where('group_id', $group_id)->update($data);
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '修改分组成功', 'data' => ''];
            }
            return ['code' => CODE_ERROR, 'msg' => '修改分组失败', 'data' => $this->getError()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function deleGroup($group_id)
    {
        try {
            $res = $this->where('group_id', $group_id)->delete();
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '删除分组成功', 'data' => ''];
            }
            return ['code' => CODE_ERROR, 'msg' => '删除分组失败', 'data' => $this->getError()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function group_rank()
    {

    }
}