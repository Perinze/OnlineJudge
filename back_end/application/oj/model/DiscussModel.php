<?php


namespace app\oj\model;


use think\Exception;
use think\Model;

class DiscussModel extends Model
{
    protected $table = 'discuss';

    public function add_discuss($data)
    {
        try{
            $info = $this->strict(false)->insert($data);
            if($info === false){
                return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function update_discuss($data)
    {
        try{
            $info = $this->where('id', $data['id'])->update($data);
            if ($info !== 0) {
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
            }
            return ['code' => CODE_ERROR, 'msg' => '更新失败', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function get_all_topic($contest, $page)
    {
        try{
            $page_limit = config('wutoj_config.page_limit');
            if($contest === 0){
                $info['data'] = $this
                    ->field(['discuss.id as id', 'discuss.problem_id as problem_id', 'problem.title as title', 'background', 'count(*) as count'])
                    ->where('contest_id', 0)
                    ->rightjoin('problem','discuss.problem_id = problem.problem_id')
                    ->group('problem.problem_id')
                    ->limit($page * $page_limit, $page_limit)
                    ->select()
                    ->toArray();
                $info['count'] = $this
                    ->where('contest_id', 0)
                    ->rightjoin('problem','discuss.problem_id = problem.problem_id')
                    ->group('problem.problem_id')
                    ->count();
            } else {
                $info['data'] = $this
                    ->field(['discuss.id as id', 'discuss.contest_id as contest_id', 'contest_name', 'begin_time', 'end_time', 'count(*) as count'])
                    ->where('discuss.contest_id', '<>', 0)
                    ->rightjoin('contest','discuss.contest_id = contest.contest_id')
                    ->group('contest.contest_id')
                    ->limit($page * $page_limit, $page_limit)
                    ->select()
                    ->toArray();
                $info['count'] = $this
                    ->where('discuss.contest_id', '<>', 0)
                    ->rightjoin('contest','discuss.contest_id = contest.contest_id')
                    ->group('contest.contest_id')
                    ->count();
            }
            if(empty($info['data'])){
                return ['code' => CODE_ERROR, 'msg' => '暂无数据', 'data' => $info];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
    public function get_all_discuss($contest_id, $problem_id, $page)
    {
        try{
            $page_limit = config('wutoj_config.page_limit');
            $field = ['discuss.id as id','problem_id','discuss.user_id as user_id', 'users.nick as nick', 'title', 'avatar', 'content', 'time', 'discuss.status as status'];
            if($contest_id !== 0){
                $info['data'] = $this
                    ->field($field)
                    ->where('contest_id', $contest_id)
                    ->join('users','discuss.user_id = users.user_id')
                    ->limit($page * $page_limit, $page_limit)
                    ->select()
                    ->toArray();
                $info['count'] = $this
                    ->where('contest_id', $contest_id)
                    ->count();
            } else {
                $info['data'] = $this
                    ->field($field)
                    ->where('problem_id', $problem_id)
                    ->where('contest_id', 0)
                    ->join('users','discuss.user_id = users.user_id')
                    ->limit($page * $page_limit, $page_limit)
                    ->select()
                    ->toArray();
                $info['count'] = $this
                    ->where('problem_id', $problem_id)
                    ->where('contest_id', 0)
                    ->count();
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function get_the_discuss($discuss_id)
    {
        try{
            $info = $this
                ->field(['discuss.id as id','problem_id','contest_id','discuss.user_id as user_id', 'users.nick as nick', 'avatar', 'title', 'content', 'time', 'discuss.status as status'])
                ->join('users','discuss.user_id = users.user_id')
                ->where('id', $discuss_id)
                ->find();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function get_user_discuss($user_id, $contest_id, $page)
    {
        try{
            $where = '(`contest_id` = '.$contest_id.' AND `discuss`.`user_id` = '.(string)$user_id.')'.'OR (`contest_id` = '.$contest_id.' AND `discuss`.`status` = 8)';
            $page_limit = config('wutoj_config.page_limit');
            $info['data'] = $this
                ->field(['discuss.id as id','problem_id','contest_id','discuss.user_id as user_id', 'users.nick as nick', 'avatar', 'title', 'content', 'time', 'discuss.status as status'])
                ->where($where)
                ->join('users','discuss.user_id = users.user_id')
                ->limit($page * $page_limit, $page_limit)
                ->select()
                ->toArray();
            $info['count'] = $this->where($where)->join('users','discuss.user_id = users.user_id')->count();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}