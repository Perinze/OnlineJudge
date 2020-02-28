<?php

namespace app\panel\model;

use think\exception\DbException;
use think\Model;

class KnowledgeTagModel extends Model {
    protected $table = 'knowledge__tag';

    /**
     * @usage 添加关系
     * @param int $knowledge_id
     * @param int $tag_id
     * @return array ['code', 'msg', 'data']
     */
    public function addKnowledgeTag($knowledge_id, $tag_id) {
        try {
            $result = $this->checkExist($knowledge_id, $tag_id);
            if ($result['code'] != CODE_SUCCESS) return $result;
            $pair = [
                'knowledge_id'  => $knowledge_id,
                'tag_id'        => $tag_id
            ];
            $result = $this->where($pair)->find();
            if ($result) {
                return ['code' => CODE_ERROR, 'msg' => '关系已存在', 'data' => []];
            } else {
                $info = $this->insertGetId($pair);
                return ['code' => CODE_SUCCESS, 'msg' => '插入成功', 'data' => $info];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除关系
     * @param int $knowledge_id
     * @param int $tag_id
     * @return array ['code', 'msg', 'data']
     */
    public function deleteKnowledgeTag($knowledge_id, $tag_id) {
        try {
            $result = $this->checkExist($knowledge_id, $tag_id);
            if ($result['code'] != CODE_SUCCESS) return $result;
            $pair = [
                'knowledge_id'  => $knowledge_id,
                'tag_id'        => $tag_id
            ];
            $result = $this->where($pair)->find();
            if ($result) {
                $info = $this->where($pair)->delete();
                return ['code' => CODE_SUCCESS, 'msg' => '插入成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除关系
     * @param int $id
     * @return array ['code', 'msg', 'data']
     */
    public function deleteKnowledgeTagByID($id) {
        try {
            $pair = ['id' => $id];
            $result = $this->where($pair)->find();
            if ($result) {
                $info = $this->where($pair)->delete();
                return ['code' => CODE_SUCCESS, 'msg' => '插入成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
    /**
     * @usage 获取标签
     * @param int $knowledge_id
     * @return array ['code', 'msg', 'data']
     */
    public function getKnowledgeTag($knowledge_id) {
        try {
            $knowledgeModel = new KnowledgeModel();
            $result = $knowledgeModel->getKnowledgeByID($knowledge_id);
            if ($result['code'] != CODE_SUCCESS) return $result;

            $where = [
                'k.knowledge_id' => $knowledge_id
            ];
            $result = $this->alias('k')
                ->join(['tag' => 'a'], 'a.id = k.tag_id')
                ->where($where)
                ->field(['a.id', 'a.name', 'a.description'])
                ->select();
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
    private function checkExist($knowledge_id, $tag_id) {
        try {
            $tagModel = new TagModel();
            $knowledgeModel = new KnowledgeModel();
            $result = $tagModel->getTheTag($tag_id);
            if ($result['code'] != CODE_SUCCESS) return $result;
            $result = $knowledgeModel->getKnowledgeByID($knowledge_id);
            if ($result['code'] != CODE_SUCCESS) return $result;
            return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => []];
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库错误', 'data' => $e->getMessage()];
        }
    }
}