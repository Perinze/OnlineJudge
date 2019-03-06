<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午12:47
 */
namespace app\oj\model;

use think\Exception;
use think\Model;

class ContestModel extends Model {

    // uncheck

    protected $table = 'contest';

    public function searchContest($contest_id) {
        try {
            $content = $this->where('contest_id', $contest_id)->find();
            return ['code'=>CODE_SUCCESS, 'msg'=>'查找成功', 'data'=>$content];
        }catch (Exception $e) {
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    public function newContest($data) {
        try{
            $res = $this->insert($data);
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'新建比赛成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'新建比赛失败', 'data'=>''];
            }
        }catch(Exception $e) {
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    public function deleContest($contest_id) {
        try{
            $res = $this->where('contest_id',$contest_id)->delete();
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'删除比赛成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'删除比赛失败', 'data'=>''];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    public function editContest($contest_id,$data) {
        try{
            $res = $this->where('contest_id',$contest_id)->update($data);
            if($res){
                return ['code'=>CODE_SUCCESS, 'msg'=>'编辑比赛成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'编辑比赛失败', 'data'=>''];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }
}