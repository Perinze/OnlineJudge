<?php


namespace app\oj\model;


use think\Exception;
use think\Model;

class GroupproblemModel extends Model
{
    protected $table = 'group_problem';

    public function addRelation($group_id, $problem_id)
    {
        try {
            $res = $this->insert(['group_id' => $group_id, 'problem_id' => $problem_id]);
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '成功', 'data' => ''];
            }
            return ['code' => CODE_ERROR, 'msg' => '已在题库中', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function getAllProblem($group_id, $page)
    {
        try{
            $page_limit = config('wutoj_config.page_limit');
            $info['data'] = $this->alias('g')
                ->field(['problem.problem_id as problem_id', 'title', 'tag'])
                ->where('group_id', $group_id)
                ->leftJoin('problem', 'problem.problem_id = g.problem_id')
                ->limit($page * $page_limit, $page_limit)
                ->select()
                ->toArray();
            $info['count'] = $this->where('group_id', $group_id)->count();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '无题目数据', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}