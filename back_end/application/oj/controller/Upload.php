<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/31
 * Time: 15:01
 */

namespace app\oj\controller;


class Upload extends Base
{
    private $validate = [
        'size' => 500000,
        'ext' => 'jpg,png,gif,jpeg',
    ];
    private $path = '../uploads/image/';

    public function upload()
    {
        $file = request()->file('image');
        $info = $file->validate($this->validate)->move($this->path);
        if ($info != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $file->getError(), '');
        } else {
            return apiReturn(CODE_SUCCESS, '上传成功', $info->getSaveName());
        }
    }

    public function uploadfile()
    {
        $files = request()->file('');
        $req = input('post.');
        $data = [];
        foreach($files['file'] as $file) {
            //halt($file);
            $info = $file->move($this->path);
            if ($info != VALIDATE_PASS) {
                return apiReturn(CODE_ERROR, $file->getError(), '');
            } else {
                $file_path = $this->path . $info->getSaveName();
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

        $json_data = json_encode($re_data);
        $json_data = str_replace('\r\n', '\n', $json_data);
        file_put_contents($this->path . $req['problem_id'] . '.json', $json_data);
    }
}