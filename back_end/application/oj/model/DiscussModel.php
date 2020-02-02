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

    public function get_all_topic($contest)
    {
        try{
            if($contest === 0){
                $info = $this
                    ->field(['discuss.id as id', 'discuss.problem_id as problem_id', 'problem.title as title', 'background'])
                    ->where('contest_id', 0)
                    ->rightjoin('problem','discuss.problem_id = problem.problem_id')
                    ->group('problem.problem_id')
                    ->select()
                    ->toArray();
            } else {
                $info = $this
                    ->field(['discuss.id as id', 'discuss.contest_id as contest_id', 'contest_name', 'begin_time', 'end_time'])
                    ->where('discuss.contest_id', '<>', 0)
                    ->rightjoin('contest','discuss.contest_id = contest.contest_id')
                    ->group('contest.contest_id')
                    ->select()
                    ->toArray();
            }
            if(empty($info)){
                return ['code' => CODE_SUCCESS, 'msg' => '暂无数据', 'data' => $info];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
    public function get_all_discuss($contest_id, $problem_id)
    {
        try{
            if($contest_id !== 0){
                $info = $this
                    ->field(['discuss.id as id','problem_id','discuss.user_id as user_id', 'users.nick as nick', 'title', 'content', 'time', 'discuss.status as status'])
                    ->where('contest_id', $contest_id)
                    ->join('users','discuss.user_id = users.user_id')
                    ->select()
                    ->toArray();
            } else {
                $info = $this
                    ->field(['discuss.id as id','problem_id','discuss.user_id as user_id', 'users.nick as nick', 'title', 'content', 'time', 'discuss.status as status'])
                    ->where('problem_id', $problem_id)
                    ->where('contest_id', 0)
                    ->join('users','discuss.user_id = users.user_id')
                    ->select()
                    ->toArray();
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function get_the_discuss($discuss_id)
    {
        try{
            $info = $this->field(['discuss.id as id','problem_id','contest_id','discuss.user_id as user_id', 'users.nick as nick', 'title', 'content', 'time', 'discuss.status as status'])->join('users','discuss.user_id = users.user_id')->where('id', $discuss_id)->find();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function get_user_discuss($user_id, $contest_id)
    {
        try{
            $where = '(`contest_id` = '.$contest_id.' AND `discuss`.`user_id` = '.(string)$user_id.')'.'OR (`contest_id` = '.$contest_id.' AND `discuss`.`status` = 8)';
            $info = $this->field(['discuss.id as id','problem_id','contest_id','discuss.user_id as user_id', 'users.nick as nick', 'title', 'content', 'time', 'discuss.status as status'])
                ->where($where)->join('users','discuss.user_id = users.user_id')->select()->toArray();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}