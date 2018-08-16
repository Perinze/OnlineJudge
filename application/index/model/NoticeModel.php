<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/8/16
 * Time: 下午11:17
 */
namespace app\index\model;

use think\exception\DbException;
use think\exception\PDOException;
use think\Model;

class NoticeModel extends Model{
    protected $table = 'Notice';

    public function addnotice($data)
    {
        try{
            $result = $this->insertGetId($data);
            if($result)
            {
                return ['code' => 0, 'msg' => 'Success', 'data' => $result];
            }else{
                return ['code' => -1, 'msg' => $this->getError(), 'data' => $result];
            }
        }catch (PDOException $e) {
            return ['code' => -1, 'msg' => $e->getMessage(), 'data' => ''];
        }
    }

    public function changestatus($noticeid,$status)
    {
        try{
            $info = $this->where('noticeId',$noticeid)->setField('status',$status);
            if($info){
                return ['code' => 0, 'msg' => 'Success', 'data' => $info];
            }else{
                return ['code' => -1, 'msg' => $this->getError(), 'data' => $info];
            }
        }catch (PDOException $e) {
            return ['code' => -1, 'msg' => $e->getMessage(), 'data' => ''];
        }
    }

    public function deletenotice($noticeid)
    {
        try{
            $info = $this->where('noticeId',$noticeid)->delete();
            if($info){
                return ['code' => 0, 'msg' => 'Success', 'data' => $info];
            }else{
                return ['code' => -1, 'msg' => $this->getError(), 'data' => $info];
            }
        }catch (PDOException $e) {
            return ['code' => -1, 'msg' => $e->getMessage(), 'data' => ''];
        }
    }

    public function getnotcielist()
    {
        try{
            $info = $this->select();
            if($info){
                return ['code' => 0, 'msg' => 'Success', 'data' => $info];
            }else{
                return ['code' => -1, 'msg' => $this->getError(), 'data' => $info];
            }
        }catch (DbException $e) {
            return ['code' => -1, 'msg' => $e->getMessage(), 'data' => ''];
        }
    }
}