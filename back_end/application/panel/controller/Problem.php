<?php
namespace app\panel\controller;
use app\panel\model\ProblemModel;
use app\oj\validate\ProblemValidate;

class problem extends Base
{
    /* 接口 */
    /**
     * 新建题目
     */
    public function addProblem()
    {
        $problem_validate = new ProblemValidate();
        $problem_model = new ProblemModel();

        $req = input('post.');
        $result = $problem_validate->scene('newProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }

        // add
        $resp = $problem_model->addProblem(array(
            'title' => $req['title'],
            'background' => $req['background'],
            'describe' => $req['describe'],
            'input_format' => isset($req['input_format']) ? $req['input_format'] : '',
            'output_format' => isset($req['output_format']) ? $req['output_format'] : '',
            'hint' => isset($req['hint']) ? $req['hint'] : '',
            'public' => isset($req['public']) ? $req['public'] : 1,
            'source' => isset($req['source']) ? $req['source'] : '',
            'tag' => isset($req['tag']) ? $req['tag'] : '',
        ));

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 删除题目
     */
    public function deleProblem()
    {

    }

    /**
     * 编辑题目
     */
    public function editProblem()
    {
        $problem_validate = new ProblemValidate();
        $problem_model = new ProblemModel();

        $req = input('post.');
        $result = $problem_validate->scene('editProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }

        // edit
        $resp = $problem_model->editProblem($req['problem_id'], array(
            'title' => $req['title'],
            'background' => $req['background'],
            'describe' => $req['describe'],
            'input_format' => isset($req['input_format']) ? $req['input_format'] : '',
            'output_format' => isset($req['output_format']) ? $req['output_format'] : '',
            'hint' => isset($req['hint']) ? $req['hint'] : '',
            'public' => isset($req['public']) ? $req['public'] : 1,
            'source' => isset($req['source']) ? $req['source'] : '',
            'tag' => isset($req['tag']) ? $req['tag'] : '',
        ));

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 查询所有题目
     */
    public function getAllProblem()
    {
        $problem_model = new ProblemModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'nick');
        $resp = $problem_model->getAllProblem($where['where'], $where['limit'], $where['offset']);
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $problem_model);
    }

    /**
     * 查询单个题目信息
     */
    public function getTheProblem()
    {
        $problem_model = new ProblemModel();
        $problem_validate = new ProblemValidate();
        $req = input('post.');
        $result = $problem_validate->scene('displayProblem')->check($req);
        if ($result !== VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $problem_validate->getError(), '');
        }
        $resp = $problem_model->searchProblemById($req['problem_id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /* 页面 */
    /**
     * 添加题目页面
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 题目详情页面
     */
    public function info()
    {
        $req = input('get.');
        $id = isset($req['id']) ? $req['id'] : 0;
        $this->assign('id', $id);
        return $this->fetch();
    }

    /**
     * 首页
     */
    public function index()
    {
        return $this->fetch();
    }

}