<?php
namespace app\panel\controller;
use think\Controller;
use think\Request;
use app\panel\model\ProblemModel;

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

    }

    /**
     * 查询单个题目信息
     */
    public function getTheProblem()
    {

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

    }

    /**
     * 首页
     */
    public function index()
    {
        return $this->fetch('index');
    }

}