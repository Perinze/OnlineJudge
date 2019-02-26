<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午1:12
 */
namespace app\oj\model;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\Model;

class SampleInputModel extends Model {
    protected $table = 'sample';

    public function addSample($problem_id, $input, $output) {
        $this->insert([
            'problem_id' => $problem_id,
            'input' => $input,
            'output' => $output
        ]);
    }

    public function searchSampleByID($id) {
        try{
            return $this->where('id',$id)->find();
        }catch (Exception $e) {
            return null;
        }
    }

    public function searchSampleByProblemID($problem_id) {
        try{
            return $this->where('problem_id',$problem_id)->select();
        }catch (Exception $e) {
            return null;
        }
    }

    public function deleSample($id) {
        $this->where('id',$id)->delete();
    }

    public function editSample($id, $input, $output) {
        $this->where('id', $id)
            ->setField([
                'input' => $input,
                'output' => $output
            ]);
    }
}