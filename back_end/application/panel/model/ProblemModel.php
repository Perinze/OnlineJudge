<?php
namespace app\panel\model;

use app\oj\model\SampleModel;
use think\Exception;
use think\exception\DbException;
use think\Model;

class ProblemModel extends Model{
    protected $table = 'problem';

    public function searchProblemById($problem_id)
    {
        try {
            $sampleModel = new SampleModel();
            $content = $this->where('problem_id', $problem_id)->find();
            $sample = $sampleModel->searchSampleByProblemID($problem_id);
            if (count($sample['data'])) {
                $content['sample_input'] = $sample['data'][0]['input'];
                $content['sample_output'] =$sample['data'][0]['output'];
            }

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
                ->order('problem_id', 'desc')
                ->select();
            if(empty($info)){
                return ['code' => CODE_ERROR,'msg' => '返回值异常','data' => $this->getError()];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '获取成功', 'data' => $info->toArray()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR,'msg' => '操作数据库异常','data' => $e->getMessage()];
        }
    }

    public function changeProblemStatus($problem_id, $data) {
        try {

            $res = $this->where('problem_id', $problem_id)->update($data);
            return ['code' => CODE_SUCCESS, 'msg' => '编辑成功', 'data' => $res];

        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function editProblem($problem_id, $data)
    {
        try {
            $sampleModel = new SampleModel();
            $insertData = [
                'title' => $data['title'],
                'background' => $data['background'],
                'describe' => $data['describe'],
                'input_format' => $data['input_format'],
                'output_format' => $data['output_format'],
                'hint' => $data['hint'] ,
                'source' =>  $data['source'],
                'public' => $data['public'],
                'tag' => $data['tag']
            ];
            $res1 = $this->where('problem_id', $problem_id)->update($insertData);
            if ($data['sample_input'] != '' && $data['sample_output'] != '') {
                $res2 = $sampleModel->editSampleByProblemID($problem_id, $data['sample_input'], $data['sample_output']);
            } else {
                $res2 = ['code' => CODE_SUCCESS];
            }
            if ($res1 !== false && $res2['code'] == CODE_SUCCESS) {
                return ['code' => CODE_SUCCESS, 'msg' => '编辑成功', 'data' => ''];
            }
            return ['code' => CODE_ERROR, 'msg' => '编辑失败', 'data' => $res2];
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
            $sampleModel = new SampleModel();
            $insertData = [
                'title' => $data['title'],
                'background' => $data['background'],
                'describe' => $data['describe'],
                'input_format' => $data['input_format'],
                'output_format' => $data['output_format'],
                'hint' => $data['hint'] ,
                'source' =>  $data['source'],
                'public' => $data['public'],
                'tag' => $data['tag']
            ];
            $res1 = $this->insertGetId($insertData);
            if ($data['sample_input'] != '' && $data['sample_output'] != '') {
                $res2 = $sampleModel->addSample($res1, $data['sample_input'], $data['sample_output']);
            } else {
                $res2 = ['code' => CODE_SUCCESS];
            }
            if ($res1 !== false && $res2['code'] == CODE_SUCCESS) {
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => ''];
            }
            return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function deleProblem($problem_id)
    {
        try {
            $res = $this->where('problem_id', $problem_id)->delete();
            if ($res !== false) {
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => ''];
            }
            return ['code' => CODE_ERROR, 'msg' => '删除失败', 'data' => ''];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}