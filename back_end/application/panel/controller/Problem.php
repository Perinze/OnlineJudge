<?php
namespace app\panel\controller;
use app\oj\model\CommonModel;
use app\panel\model\ProblemModel;
use app\oj\validate\ProblemValidate;

class problem extends Base
{
    private $data_path = '../../../../../root/FinalRank/FinalRank/data/';
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
            'sample_input' => isset($req['sample_input']) ? $req['sample_input'] : '',
            'sample_output' => isset($req['sample_output']) ? $req['sample_output'] : '',
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
        $problem_model = new ProblemModel();

        $req = input('get.');
        if (!isset($req['id'])) {
            return apiReturn(CODE_ERROR, '没有用户id', '');
        }
        $resp = $problem_model->deleProblem($req['id']);
        $this->redirect('panel/problem/index');
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
            'sample_input' => isset($req['sample_input']) ? $req['sample_input'] : '',
            'sample_output' => isset($req['sample_output']) ? $req['sample_output'] : '',
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

    /**
     * 上传题目数据接口, 支持多组数据
     */
    public function upload_data_file()
    {
        $files = request()->file('');
        $req = input('post.');
        $data = [];
        foreach($files['file'] as $file) {
            //halt($file);
            $info = $file->move($this->data_path);
            if ($info != VALIDATE_PASS) {
                return apiReturn(CODE_ERROR, $file->getError(), '');
            } else {
                $file_path = $this->data_path . (str_replace('\\', '/', $info->getSaveName()));
                $str = file_get_contents($file_path);
                //$str = str_replace("\r\n", '\n', $str);
                $filename = substr($file->getInfo()['name'], 0, strpos($file->getInfo()['name'], '.'));
                if (!isset($data[$filename])) {
                    if ($info->getExtension() === 'in') {
                        $data[$filename] = array(
                            'in' => $str,
                            'out' => ''
                        );
                    } else {
                        $data[$filename] = array(
                            'in' => '',
                            'out' => $str
                        );
                    }
                } else {
                    if ($info->getExtension() === 'in') {
                        $data[$filename]['in'] = $str;
                    } else {
                        $data[$filename]['out'] = $str;
                    }
                }
            }
        }

        if(!isset($req['sqj'])){
            $re_data = array(
                'type' => 'Normal',
                'time_limit' => isset($req['time']) ? $req['time'] : 1000000000,
                'memory_limit' => isset($req['memory']) ? $req['memory'] : 33554432,
                'test_cases' => array()
            );
        } else {
            $re_data = array(
                'type' => 'Special',
                'time_limit' => isset($req['time']) ? $req['time'] : 1000000000,
                'memory_limit' => isset($req['memory']) ? $req['memory'] : 33554432,
                'spj' => array(
                    'language' => $req['language'],
                    'code' => $req['code']
                ),
                'test_cases' => array()
            );
        }
        foreach ($data as $item){
            $re_data['test_cases'][] = array(
                'input' => $item['in'],
                'answer' => $item['out'],
            );
        }

        // 数据文件输出
        $json_data = json_encode($re_data);
        $json_data = str_replace('\r\n', '\n', $json_data);
        file_put_contents($this->data_path . $req['problem_id'] . '.json', $json_data);

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
     * 添加数据
     */
    public function data()
    {
        $req = input('get.');
        $problem_id = isset($req['id']) ? $req['id'] : 0;
        $this->assign('problem_id', $problem_id);
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