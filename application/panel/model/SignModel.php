<?php
namespace app\panel\model;
use think\Model;
use think\exception\PDOException;

class SignModel extends Model
{
    protected $table = 'sign';

    public function addsign($data)
    {
        try {
            $where = ['cardNo' => $data['cardNo']];
            if(getsign($where)){
                $info = $this->strict(false)->update(array('update_time'=>time()));
                return ['code' => 0, 'msg' => 'Success', 'data' => $info];
            }
            else{
                $info = $this->strict(false)->insertGetId($data);
                if ($info === false) {
                    return ['code' => -1, 'msg' => $this->getError(), 'data' => $info];
                } 
                else {
                    return ['code' => 0, 'msg' => 'Success', 'data' => $info];
                }
            }
        } 
        catch (PDOException $e) {
            return ['code' => -1, 'msg' => $e->getMessage(), 'data' => ''];
        }
    }

    public function getsign($where, $offset, $limit)
    {
        try {
            $info = $this->where($where)
                ->limit($offset, $limit)
                ->select();
            if ($info === false) {
                return ['code' => -1, 'msg' => $this->getError(), 'data' => $info];
            } 
            else {
                return ['code' => 0, 'msg' => 'Success', 'data' => $info];
            }
        } 
        catch (PDOException $e) {
            return ['code' => -1, 'msg' => $e->getMessage(), 'data' => ''];
        }
    }

    public function changestatus($signid, $status)
    {
        try {
            $info = $this->where('id', '=', $signid)->update(array('status'=>$status));
            if ($info === false) {
                return ['code' => -1, 'msg' => $this->getError(), 'data' => $info];
            } 
            else {
                return ['code' => 0, 'msg' => 'Success', 'data' => $info];
            }
        } 
        catch (PDOException $e) {
            return ['code' => -1, 'msg' => $e->getMessage(), 'data' => ''];
        }
    }

    public function getthesign($signid)
    {
        $where = ['id' => $signid];
        try {
            $info = $this->where($where)
                ->find();
            if ($info === false) {
                return ['code' => -1, 'msg' => $this->getError(), 'data' => $info];
            } 
            else {
                return ['code' => 0, 'msg' => 'Success', 'data' => $info];
            }
        } 
        catch (PDOException $e) {
            return ['code' => -1, 'msg' => $e->getMessage(), 'data' => ''];
        }
    }
}