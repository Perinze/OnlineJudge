<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 18:04
 */

namespace app\oj\model;

use think\Exception;
use think\Model;

class UsergroupModel extends Model
{

    // TODO handle duplicated key such as '1 1' then insert '1 1'

    protected $table = 'user_group';

    public function find_group($user_id, $page)
    {
        try {
            $page_limit = config('wutoj_config.page_limit');
            $info['data'] = $this->alias(['user_group' => 'ug'])
                ->field(['ug.group_id as group_id', 'group.avatar as avatar', 'group_name', 'identity', 'desc'])
                ->where('user_id', $user_id)
                ->where('group.status', 0)
                ->rightJoin('group', 'ug.group_id = group.group_id')
                ->group('ug.group_id')
                ->withAttr('identity', function($value) {
                    $identity = [0=>'正常', 1=>'管理员', 2=>'创建者'];
                    return $identity[$value];
                })
                ->limit($page * $page_limit, $page_limit)
                ->select()
                ->toArray();
            if (empty($info['data'])) {
                return ['code' => CODE_ERROR, 'msg' => '暂无数据', 'data' => ''];
            }
            foreach ($info['data'] as &$item){
                $item['count'] = $this->where('group_id', $item['group_id'])->count();
            }
            $info['count'] = $this->alias(['user_group' => 'ug'])->where('user_id', $user_id)
                ->where('group.status', 0)->rightJoin('group', 'ug.group_id = group.group_id') ->count();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function find_user($group_id)
    {
        try {
            $info = $this->alias(['user_group' => 'ug'])
                ->field(['ug.user_id as user_id', 'ug.identity as identity', 'nick'])
                ->where('group_id', $group_id)
                ->rightJoin('users', 'ug.user_id = users.user_id')
                ->withAttr('identity', function($value) {
                    $identity = [0=>'正常', 1=>'管理员', 2=>'创建者'];
                    return $identity[$value];
                })
                ->select()
                ->toArray();
            if (empty($info)) {
                return ['code' => CODE_ERROR, 'msg' => '暂无数据', 'data' => ''];
            }
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    /**
     * @param $group_id
     * @param $user_id
     * @return array['int','string','object']
     */
    public function searchRelation($group_id, $user_id)
    {
        try {
            $content = $this->where([['group_id', '=', $group_id, 'user_id', '=', $user_id]])->select()[0]; // return object
            if ($content) {
                return ['code' => CODE_SUCCESS, 'msg' => '成功', 'data' => $content];
            }
            return ['code' => CODE_ERROR, 'msg' => '失败', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function addRelation($group_id, $user_id, $identity)
    {
        try {
            $res = $this->insert(['group_id' => $group_id, 'user_id' => $user_id, 'identity' => $identity]);
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '成功', 'data' => ''];
            }
            return ['code' => CODE_ERROR, 'msg' => '你已在团队中', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
    public function deleRelation($group_id, $user_id)
    {
        try {
            $res = $this->where([['group_id', '=', $group_id, 'user_id', '=', $user_id]])->delete();
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '成功', 'data' => ''];
            }
            return ['code' => CODE_ERROR, 'msg' => '失败', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}