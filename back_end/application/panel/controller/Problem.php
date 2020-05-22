<?php
namespace app\panel\controller;
use app\oj\model\CommonModel;
use app\panel\model\ProblemModel;
use app\oj\validate\ProblemValidate;
use Yosymfony\Toml\TomlBuilder;

class problem extends Base
{
    private $data_path = '../finalrank/data/';
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
        $this->redirect('/back_end/panel/problem/index');
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
            $info = $file->move($this->data_path.'tmp/', '');
            if ($info != VALIDATE_PASS) {
                return apiReturn(CODE_ERROR, $file->getError(), '');
            } else {
                $file_path = $this->data_path.'tmp/' . (str_replace('\\', '/', $info->getSaveName()));
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
        $dir = iconv('UTF-8', 'GBK', $req['problem_id']);
        $dir = $this->data_path . $dir;
        if (!file_exists($dir)) {
            if(!mkdir($dir, 0755, true) || !is_dir($dir)){
                return apiReturn(CODE_ERROR, '创建目录失败', '');
            }
        }
        $problem_path = $dir.'/problem';
        if (!file_exists($problem_path)) {
            if(!mkdir($problem_path, 0755, true) || !is_dir($problem_path)){
                return apiReturn(CODE_ERROR, '创建目录失败', '');
            }
        }
        $toml = new TomlBuilder();
        $secs = isset($req['secs']) ? (int)$req['secs'] : 1;
        $nanos = isset($req['nanos']) ? (int)$req['nanos'] * 100000000 : 0;
        if(isset($req['spj'])){
            // extern_problem文件夹创建
            $spj_toml = new TomlBuilder();
            $spj_path = $problem_path.'/extern_program';
            if (!file_exists($spj_path)) {
                if(!mkdir($spj_path, 0755, true) || !is_dir($spj_path)){
                    return apiReturn(CODE_ERROR, '创建目录失败', '');
                }
            }
            // spj文件config
            $spj_name = 'spj'.substr($req['language'],0, strpos($req['language'], '.'));
            file_put_contents($spj_path.'/config.toml', $spj_toml->addValue('source', $spj_name)
                ->addValue('language', $req['language'])
                ->addTable('timeout')
                ->addValue('secs', 5)
                ->addValue('nanos', 0)
                ->getTomlString());
            // 输出spj代码
            file_put_contents($spj_path.'/'.$spj_name, $req['code']);
            // 题目config
            $toml->addValue('problem_type', 'SpecialJudge');
            $toml->addTable('limit')
                ->addValue('memory', isset($req['memory']) ? $req['memory'] * 1024 * 1024 : 33554432)
                ->addTable('limit.real_time')
                ->addValue('secs', $secs)
                ->addValue('nanos', $nanos)
                ->addTable('limit.cpu_time')
                ->addValue('secs', $secs)
                ->addValue('nanos', $nanos);
            $toml->addTable('source')
                ->addValue('source', $spj_name)
                ->addValue('language', $req['language']);
            file_put_contents($problem_path.'/config.toml', $toml->getTomlString());
        } else {
            //题目config
            $toml->addValue('problem_type', 'Normal');
            $toml->addTable('limit')
                ->addValue('memory', isset($req['memory']) ? $req['memory'] * 1024 * 1024 : 33554432)
                ->addTable('limit.real_time')
                ->addValue('secs', $secs)
                ->addValue('nanos', $nanos)
                ->addTable('limit.cpu_time')
                ->addValue('secs', $secs)
                ->addValue('nanos', $nanos);
            file_put_contents($problem_path.'/config.toml', $toml->getTomlString());
        }
        $i = 0;
        foreach ($data as $item){
            $data_path = $problem_path.'/'.(string)$i;
            if (!file_exists($data_path)) {
                if(!mkdir($data_path, 0755, true) || !is_dir($data_path)){
                    return apiReturn(CODE_ERROR, '创建目录失败', '');
                }
            }
            file_put_contents($data_path.'/answer', str_replace('\r\n', '\n', $item['out']));
            file_put_contents($data_path.'/input', str_replace('\r\n', '\n', $item['in']));
            $i++;
        }
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