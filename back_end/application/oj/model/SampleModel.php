<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午1:12
 */
namespace app\oj\model;

use think\Exception;
use think\Model;

class SampleModel extends Model {
    protected $table = 'sample';

    public function addSample($problem_id, $input, $output) {
        try {
            $res = $this->insert([
                'problem_id' => $problem_id,
                'input' => $input,
                'output' => $output
            ]);
            if($res) {
                return ['code'=>CODE_SUCCESS , 'msg'=>'添加成功' , 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR , 'msg'=>'添加失败' , 'data'=>''];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR , 'msg'=>'数据库异常' , 'data'=>$e->getMessage()];
        }
    }

    public function searchSampleByID($id) {
        try{
            $content = $this->where('sample_id',$id)->find();
            return ['code'=>CODE_SUCCESS , 'msg'=>'查找成功' , 'data'=>$content];
        }catch (Exception $e) {
            return ['code'=>CODE_ERROR , 'msg'=>'数据库异常' , 'data'=>$e->getMessage()];
        }
    }

    public function searchSampleByProblemID($problem_id) {
        try{
            $content = $this->where('problem_id',$problem_id)->select();
            return ['code'=>CODE_SUCCESS , 'msg'=>'查找成功' , 'data'=>$content];
        }catch (Exception $e) {
            return ['code'=>CODE_ERROR , 'msg'=>'数据库异常' , 'data'=>$e->getMessage()];
        }
    }

    public function deleSample($id) {
        try {
            $res = $this->where('sample_id', $id)->delete();
            if ($res) {
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => ''];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '删除失败', 'data' => ''];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR , 'msg'=>'数据库异常' , 'data'=>$e->getMessage()];
        }
    }

    public function editSample($id, $input, $output) {
        try {
            $res = $this->where('sample_id', $id)
                ->setField([
                    'input' => $input,
                    'output' => $output
                ]);
            if($res){
                return ['code'=>CODE_SUCCESS , 'msg'=>'编辑成功' , 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR , 'msg'=>'编辑失败' , 'data'=>''];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR , 'msg'=>'数据库异常' , 'data'=>$e->getMessage()];
        }
    }
}