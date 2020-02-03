<?php

namespace app\oj\model;

use think\exception\DbException;
use think\Model;

class KnowledgeUserModel extends Model
{
    protected $table = 'knowledge__user';

    /**
     * @usage 添加进行的知识点
     * @param int $user_id
     * @param string $knowledge
     * @return array ['code', 'msg', 'data']
     */
    public function addDoingKnowledge($user_id, $knowledge) {
        try {

        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => $e->getMessage(), 'data' => []];
        }
    }


    /**
     * @usage 添加完成知识点
     * @param int $user_id
     * @param string $knowledge
     * @return array ['code', 'msg', 'data']
     */
    public function addDoneKnowledge($user_id, $knowledge) {

    }
}