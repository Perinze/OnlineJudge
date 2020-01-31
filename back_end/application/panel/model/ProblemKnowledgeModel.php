<?php

namespace app\panel\model;

use Exception;
use think\facade\Cache;
use think\exception\DbException;
use think\Model;

class ProblemKnowledgeModel extends Model {
    protected $table = 'problem__knowledge';

    /**
     * @usage 获取知识点问题
     * @param string $knowledge
     * @param boolean $core_only
     * @return array ['code', 'msg', 'data']
     */
    public function getProblemByKnowledge($knowledge, $core_only = false) {
        try {
            $knowledgeModel = new KnowledgeModel();
            $msg = $knowledgeModel->getSpecificKnowledge($knowledge);
            if ($msg == CODE_SUCCESS) {
                $where = [
                    'a.knowledge_id' => $msg['data']['id'],
                ];
                if ($core_only) {
                    $where['a.is_core'] = 1;
                }
                $result = $this->alias('a')
                    ->join(['problem' => 'p'], 'p.problem_id = a.problem_id')
                    ->where($where)
                    ->field(['p.problem_id', 'a.is_core'])
                    ->select();
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '知识点不存在', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取问题知识点
     * @param int $problem_id
     * @param boolean $core_only
     * @return array ['code', 'msg', 'data']
     */
    public function getKnowledgeByProblem($problem_id, $core_only = false) {
        $cacheModel = new CacheModel();
        $cache = $cacheModel->getProblemKnowledgeCache($problem_id, $core_only);
        if ($cache['code'] == CODE_SUCCESS) {
            return $cache;
        }
        try {
            $problemModel = new ProblemModel();
            $msg = $problemModel->searchProblemById($problem_id);
            if ($msg) {
                $where = ['a.problem_id' => $problem_id];
                if ($core_only == true) {
                    $where['is_core'] = 1;
                }
                $result = $this->alias('a')
                    ->join(['knowledge' => 'k'], 'k.id = a.knowledge_id')
                    ->where($where)
                    ->field(['k.id', 'k.name', 'a.is_core'])
                    ->select();
                $cacheModel->setProblemKnowledgeCache($result, $problem_id, $core_only);
                return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '知识点不存在', 'data' => []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 添加关系
     * @param array $data ['problem_id', 'knowledge'， 'is_core']
     * @return array ['code', 'msg', 'data']
     */
    public function addRelation($data) {
        try {
            $msg = $this->getRelationPair($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                return ['code' => CODE_ERROR, 'msg' => '关系已存在', 'data' => []];
            } else {
                $insertData = [
                    'problem_id' => $id_pair['problem_id'],
                    'knowledge_id' => $id_pair['knowledge_id'],
                    'is_core' => isset($data['is_core'])?$data['is_core']:0,
                ];
                $info = $this->insertGetId($insertData);
                $cacheModel = new CacheModel();
                $cacheModel->unsetProblemKnowledgeCache($insertData['problem_id'], $insertData['is_core']);
                return ['code' => CODE_SUCCESS, 'msg' => '插入成功', 'data' => $info];
            }

        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取关系对id
     * @param array $data ['problem_id', 'knowledge']
     * @return array ['code', 'msg', 'data']
     */
    public function getRelationPair($data) {
        $knowledgeModel = new KnowledgeModel();
        $problemModel = new ProblemModel();
        $msg = $knowledgeModel->getSpecificKnowledge($data['knowledge']);
        if ($msg['code'] == CODE_SUCCESS) {
            $knowledge_id = $msg['data']['id'];
        } else {
            return $msg;
        }
        $msg = $problemModel->searchProblemById($data['problem_id']);
        if ($msg['code'] == CODE_ERROR) {
            return ['code' => CODE_ERROR, 'msg' => '题目编号不存在', 'data' => []];
        }
        $returnData = [
            'knowledge_id' => $knowledge_id,
            'problem_id'   => $data['problem_id']
        ];
        return ['code' => CODE_SUCCESS, 'msg' => '查找成功', 'data' => $returnData];
    }


    /**
     * @usage 删除关系
     * @param array $data ['problem_id', 'knowledge']
     * @return array ['code', 'msg', 'data']
     */
    public function deleteRelation($data) {
        try {
            $msg = $this->getRelationPair($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair  = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                $where = [
                    'id' => $msg['id'],
                ];
                $info = $this->where($where)->delete();
                $cacheModel = new CacheModel();
                $cacheModel->unsetProblemKnowledgeCache($data['problem_id'], true);
                $cacheModel->unsetProblemKnowledgeCache($data['problem_id'], false);
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 切换必要题目
     * @param array $data ['problem_id', 'knowledge']
     * @return array ['code', 'msg', 'data']
     */
    public function switchCore($data) {
        try {
            $msg = $this->getRelationPair($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair  = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                $where = [ 'id' => $msg['id']];
                if ($msg['is_core'] == 1) {
                    $updateData = ['is_core' => 0];
                } else {
                    $updateData = ['is_core' => 1];
                }
                $info = $this->where($where)->update($updateData);
                $cacheModel = new CacheModel();
                $cacheModel->unsetProblemKnowledgeCache($data['problem_id'], true);
                $cacheModel->unsetProblemKnowledgeCache($data['problem_id'], false);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 设置必要题目
     * @param array $data ['problem_id', 'knowledge']
     * @return array ['code', 'msg', 'data']
     */
    public function setCore($data) {
        try {
            $msg = $this->getRelationPair($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair  = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                $where = [ 'id' => $msg['id']];
                $updateData = ['is_core' => 1];
                $info = $this->where($where)->update($updateData);
                $cacheModel = new CacheModel();
                $cacheModel->unsetProblemKnowledgeCache($data['problem_id'], true);
                $cacheModel->unsetProblemKnowledgeCache($data['problem_id'], false);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 取消设置必要题目
     * @param array $data ['problem_id', 'knowledge']
     * @return array ['code', 'msg', 'data']
     */
    public function unsetCore($data) {
        try {
            $msg = $this->getRelationPair($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair  = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                $where = [ 'id' => $msg['id']];
                $updateData = ['is_core' => 0];
                $info = $this->where($where)->update($updateData);
                $cacheModel = new CacheModel();
                $cacheModel->unsetProblemKnowledgeCache($data['problem_id'], true);
                $cacheModel->unsetProblemKnowledgeCache($data['problem_id'], false);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}