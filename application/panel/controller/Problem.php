<?php
namespace app\panel\controller;
use think\Controller;
use think\Request;
use app\panel\model\ProblemModel;

class problem extends Controller
{
    public function contract()
    {
        return $this->fetch();
    }

    public function add_problem()
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
}