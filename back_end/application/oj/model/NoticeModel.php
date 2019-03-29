<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/29
 * Time: 17:02
 */

namespace app\oj\model;


use think\Exception;
use think\Model;

class NoticeModel extends Model
{
    protected $table = 'notice';
    public function add_notice($data)
    {
        try{
            $info = $this->strict(false)->insert($data);
            if($info != true){
                return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    public function delete_notice($id)
    {
        try{
            if (!$this->where('id', $id)->find()) {
                return ['code' => USERNAME_IS_EXIST, 'msg' => '该公告不存在', 'data' => $this->getError()];
            }
            $info = $this->where('id', $id)->delete();
            if($info != true){
                return ['code' => CODE_ERROR, 'msg' => '删除失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => $info];
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    public function get_all_notice()
    {
        try{
            $info = $this->where([['begintime', '< time', time()], ['endtime', '> time', time()]])->select();
            if($info != true){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info->toArray()];
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    public function get_the_notice($id)
    {
        try{
            $info = $this->where('id', $id)->find();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }
}