<?php
namespace app\index\model;

use think\exception\DbException;
use think\Model;

class ProblemModel extends Model{
    protected $table = 'problem';

    public function add($where, $data)
    {
        try{
            $info = $this->where($where)->find();
            if($info){
                return ['code' => -1, 'msg' => '已有该名字，请重新取名', 'data' => $info];
            }
            else{
                $info = $this->insertGetId($data);
                return ['code' => 1, 'msg' => '成功', 'data' => $info];
            } 
        }catch (DbException $e) {
            return false;
        }
        return false;
    }

    public function getall()
    {
        try{
            $info = $this->find();
            if($info){
                return $info->toArray();
            }
        }catch (DbException $e) {
            return false;
        }
        return false;
    }

    public function getone($where)
    {
        try{
            $info = $this->where($where)
                ->select();
            if($info){
                return $info->toArray();
            }
        }catch (DbException $e) {
            return false;
        }
        return false;
    }
}