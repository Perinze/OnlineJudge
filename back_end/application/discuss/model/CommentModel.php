<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/3/1
 * Time: 下午11:20
 */
namespace app\discuss\model;

use think\Exception;
use think\Model;

class CommentModel extends Model {
    protected $table = 'question';

    /**
     * 新建评论
     * @param $data : $user_id $question_id $content(评论内容)
     * @return array
     */
    public function newComment($data) {
        try{
            $res = $this->insert($data);
            if($res) {
                return ['code'=>CODE_SUCCESS, 'msg'=>'评论成功', 'data'=>''];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'评论失败', 'data'=>''];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    /**
     * 查找评论
     * @param $comment_id
     * @return array
     */
    public function searchComment($comment_id) {
        try {
            $content = $this->where('comment_id', $comment_id)->find();
            if(!empty($content)) {
                return ['code'=>CODE_SUCCESS, 'msg'=>'查找成功', 'data'=>$content];
            }else{
                return ['code'=>CODE_ERROR, 'msg'=>'查找失败', 'data'=>'不存在查找项'];
            }
        }catch(Exception $e){
            return ['code'=>CODE_ERROR, 'msg'=>'数据库错误', 'data'=>$e->getMessage()];
        }
    }

    /**
     * 编辑回复
     * 只允许admin权限使用
     * @param $comment_id
     */
    public function deleComment($comment_id) {

    }
}