<?php
namespace app\panel\controller;
use app\oj\model\ProblemModel;
use app\oj\validate\ProblemValidate;
use think\Controller;
use think\Request;

class problem extends Base
{
    /* 接口 */
    /**
     * 添加题目
     */
    public function addProblem()
    {
        $info = input('get.');
        $problem = request()->file('problem');
        $io = request()->file('io');
        $count = count(Db::table('problem')->find());
        $url = '';
        if($problem){
            $rel = $problem->move($url, 'WUT'.string($count).'/WUT'.string($count));//目录需修改
        }
        if($io){
            $rel = $io->move($url, 'WUT'.string($count).'/io');
        }
        $created = time();
        $data = array(
            'name' => $info['name'],
            'userName' => $_SESSION['userName'],
            'status' => 1,
            'create_time' => $created,
            'update_time' => $created
        );
        $item = new ProblemModel();
        $where = ['name' => $data['name']];
        $rel = $item->addsign($where, $data);
        return apireturn($rel['code'], $rel['msg'], $rel['data'], 200);
    }

    /**
     * 删除题目
     */
    public function deleProblem()
    {

    }

    /**
     * 修改题目
     */
    public function editProblem()
    {

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