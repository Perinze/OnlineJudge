<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/29
 * Time: 19:48
 */

namespace app\oj\model;


use think\Exception;
use think\Model;

class RotationModel extends Model
{
    protected $table = 'rotation';
    public function add_rotation($data)
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

    public function delete_rotation($id)
    {
        try{
            if (!$this->where('id', $id)->find()) {
                return ['code' => USERNAME_IS_EXIST, 'msg' => '该轮播图不存在', 'data' => $this->getError()];
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

    public function get_all_rotation()
    {
        try{
            $info = $this->where('status', 1)->select();
            if($info != true){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info->toArray()];
        } catch (Exception $e){
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => ''];
        }
    }

    public function get_the_rotation($id)
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