<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/29
 * Time: 19:42
 */

namespace app\oj\model;


use think\Db;
use think\Exception;
use think\Model;

class SubmitModel extends Model
{
    protected $table = 'submit';

    public function get_all_submit($where, $order = 'asc')
    {
        try {
            $info = $this->field(['submit.user_id as user_id', 'submit.nick as nick', 'avatar', 'users.realname as realname', 'language', 'users.school as school','problem_id', 'submit.status as status', 'time', 'memory', 'submit_time'])
                ->where($where)
                ->withAttr('language', function($value) {
                    $language = [0=>'c.gcc', 1=>'cpp.g++', 2=>'java.openjdk10', 3=>'python.cpython3.6'];
                    return $language[$value];
                })
                ->leftJoin('users', 'submit.user_id = users.user_id')
                ->order('submit.id', $order)->select()->toArray();
            foreach ($info as &$item){
                $item['nick'] = $item['realname'].' '.$item['school'];
                unset($item['realname']);
                unset($item['school']);
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }

    // TODO 重构
    public function get_the_submit($where, $page)
    {
        try {
            $page_limit = config('wutoj_config.page_limit');
            $language = config('wutoj_config.language');
            $sql = $this
                ->field(['submit.id as runid','submit.user_id as user_id','users.nick as nick', 'avatar', 'problem_id', 'language', 'submit.status as status', 'time', 'memory', 'submit_time'])
                ->where($where)
                ->order('submit.id', 'desc')
                ->limit($page * $page_limit, $page_limit)
                ->join('users','submit.user_id = users.user_id')
                ->buildSql();
            $info['submit_info'] = Db::query($sql);
            foreach ($info['submit_info'] as &$item){
                $item['language'] = $language[$item['language']];
            }
            $info['count'] = $this->where($where)->count();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    public function get_a_submit($where){
        try {
            $language = config('wutoj_config.language');
            $info = $this->field(['submit.id as runid','submit.user_id as user_id','users.nick as nick', 'problem_id', 'language', 'submit.status as status', 'time', 'memory', 'submit_time', 'source_code', 'msg'])
                ->where($where)->order('submit_time')->join('users','submit.user_id = users.user_id')->buildSql();
            $info = Db::query($info);
            foreach ($info as &$item){
                $item['language'] = $language[$item['language']];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }
    public function add_submit($data)
    {
        $info = $this->strict(false)->insertGetId($data);
        if ($info === 0) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
        return ['code' => CODE_SUCCESS, 'msg' => '提交成功', 'data' => $info];
    }

    /**
     * @param $where
     * @param $page
     * @return array
     * 等憨批叫我写分页的时候用
     */
    public function get_page_submit($where, $page)
    {
        try {
            $info = $this->field(['user_id', 'nick', 'problem_id', 'status', 'time', 'memory', 'submit_time'])
                ->where($where)->order('submit_time')->page($page,10)->select()->toArray();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getTrace()];
        }
    }
}