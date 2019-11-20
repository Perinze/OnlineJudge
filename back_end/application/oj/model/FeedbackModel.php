<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/12/3
 * Time: 17:06
 */
namespace app\oj\model;

use think\Model;
use think\Exception;
class FeedbackModel extends Model
{
    protected $table = 'feedback';
    
    public function add_feedback($data)
    {
        try {
            $ok = $this->strict(false)->insert($data);
            if ($ok == false) {
                return ['code' => CODE_ERROR, 'msg' => '添加失败', 'data' => $this->getError()];
            } else {
                return ['code' => CODE_SUCCESS, 'msg' => '添加成功', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}