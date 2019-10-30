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

class ProblemModel extends Model
{

    // uncheck

    protected $table = 'problem';

    public function get_all_problem()
    {
        try {
            $info = $this->alias('p')
                ->field(['p.problem_id as problem_id', 'title', 'tag',
                    'count(case when submit.status="AC" then submit.status end) as ac',
                    'count(case when submit.status="WA" then submit.status end) as wa',
                    'count(case when submit.status="TLE" then submit.status end) as tle',
                    'count(case when submit.status="MLE" then submit.status end) as mle',
                    'count(case when submit.status="RE" then submit.status end) as re',
                    'count(case when submit.status="SE" then submit.status end) as se',
                    'count(case when submit.status="CE" then submit.status end) as ce'])
                ->where('p.status', USING)
                ->join('submit', 'p.problem_id = submit.problem_id')->group('p.problem_id')->select()->toArray();
            if (empty($info)) {
                return ['code' => CODE_ERROR, 'msg' => '查找失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function searchProblemById($problem_id)
    {
        try {
            $content = $this->where('problem_id', $problem_id)->find();
            if ($content) {
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '查找失败', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function searchProblemByTitle($title)
    {
        try {
            $content = $this->where('title', 'like', '%' . $title . '%')->select()->toArray();
            if ($content) {
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $content];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '查找失败', 'data' => ''];
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
            } else {
                return ['code' => CODE_ERROR, 'msg' => '删除失败', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
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
}