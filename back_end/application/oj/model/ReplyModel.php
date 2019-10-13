<?php


namespace app\oj\model;


use think\Exception;
use think\Model;

class ReplyModel extends Model
{
    protected $table = 'reply';

    public function add_reply($data)
    {
        try{
            $info = $this->strict(false)->insert($data);
            if($info === false){
                return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => ''];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    public function get_the_discuss($discuss_id)
    {
        try{
            $info = $this->where('discuss_id', $discuss_id)->select()->toArray();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $info];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}