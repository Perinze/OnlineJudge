<?php


namespace app\panel\model;


use think\Exception;
use think\Model;

class TagModel extends Model
{
    protected $table = 'tag';

    public function getAllTag($where, $limit, $offset)
    {
        try{
            $info = $this
                ->where($where)
                ->limit($limit, $offset)
                ->withAttr('status', function($value) {
                    $status = [-1=>'删除', 0=>'禁用', 1=>'正常'];
                    return $status[$value];
                })
                ->select()
                ->toArray();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function getTheTag($id)
    {
        try{
            $info = $this->where('id', $id)->find();
            if(empty($info)){
                return ['code' => CODE_ERROR, 'msg' => '查询失败', 'data' => $info];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function addTag($data)
    {
        try{
            $info = $this->strict(false)->insert($data);
            if($info === false){
                return ['code' => CODE_ERROR, 'msg' => '添加标签失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '添加标签成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function editTag($data)
    {
        try{
            $info = $this->where('id', $data['id'])->update($data);
            if($info === false){
                return ['code' => CODE_ERROR, 'msg' => '编辑标签失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '编辑标签成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function deleTag($id)
    {
        try{
            $info = $this->where('id', $id)->delete();
            if($info === false){
                return ['code' => CODE_ERROR, 'msg' => '删除标签失败', 'data' => ''];
            }
            return ['code' => CODE_SUCCESS, 'msg' => '删除标签成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}