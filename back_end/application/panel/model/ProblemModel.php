<?php
namespace app\panel\model;

use think\Exception;
use think\exception\DbException;
use think\Model;

class ProblemModel extends Model{
    protected $table = 'problem';

    public function searchProblemById($problem_id)
    {
        try {
            $content = $this->where('problem_id', $problem_id)->find();
            if ($content) {
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
            }
            return ['code' => CODE_ERROR, 'msg' => '查找失败', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function getAllProblem($where, $limit, $offset)
    {
        try{
            $field = ['p.problem_id as problem_id', 'title', 'public', 'count(case when submit.status="AC" then submit.status end) as ac', 'p.status as status'];
            $info = $this->alias('p')
                ->field($field)
                ->where($where)
                ->leftJoin('submit', 'p.problem_id = submit.problem_id')
                ->group('p.problem_id')
                ->limit($offset, $limit)
                ->withAttr('status', function($value) {
                    $status = [-1=>'删除', 0=>'禁用', 1=>'正常', 2=>'比赛'];
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

    public function editProblem($problem_id, $data)
    {
        try {
            $res = $this->where('problem_id', $problem_id)->update($data);
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '编辑成功', 'data' => ''];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '编辑失败', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    /**
     * @param $data : $title, $background, $describe, $input_format, $output_format, $hint, $public(boolean), $source, $tag
     * @return array
     */
    public function addProblem($data)
    {
        try {
            $res = $this->insert($data);
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => ''];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function deleProblem($problem_id)
    {
        try {
            $res = $this->where('problem_id', $problem_id)->delete();
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => ''];
            }
            return ['code' => CODE_ERROR, 'msg' => '删除失败', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}