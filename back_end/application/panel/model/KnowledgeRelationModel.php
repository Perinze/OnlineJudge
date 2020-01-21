<?php

namespace app\panel\model;

use think\exception\DbException;
use think\Model;

class KnowledgeRelationModel extends Model {
    protected $table = 'knowledge_relationship';

    /**
     * @usage 添加知识点关系
     * @param array $data ['name', 'pre_name', 'is_core']
     * @return array ['code', 'msg', 'data']
     */
    public function addRelation($data) {
        try {
            if ($data['name'] == $data['pre_name']) {
                return ['code' => CODE_ERROR, 'msg' => '前后知识点相同', []];
            }
            $knowledgeModel = new KnowledgeModel();
            $msg = $knowledgeModel->getKnowledgePairID($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                return ['code' => CODE_ERROR, 'msg' => '关系已存在', []];
            } else {
                $insertData = [
                    'knowledge_id' => $id_pair['knowledge_id'],
                    'pre_knowledge_id' => $id_pair['pre_knowledge_id'],
                    'is_core' => isset($data['is_core'])?$data['is_core']:0,
                ];
                $info = $this->insertGetId($insertData);
                return ['code' => CODE_SUCCESS, 'msg' => '插入成功', 'data' => $info];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除知识点关系
     * @param array $data ['name', 'pre_name', 'is_core']
     * @return array ['code', 'msg', 'data']
     */
    public function deleteRelation($data)
    {
        try {
            $knowledgeModel = new KnowledgeModel();
            $msg = $knowledgeModel->getKnowledgePairID($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                $where = [
                    'id' => $msg['id'],
                ];
                $info = $this->where($where)->delete();
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 删除知识点关系(ID)
     * @param int $id
     * @return array ['code', 'msg', 'data']
     */
    public function deleteRelationByID($id)
    {
        try {
            $where = ['id' => $id];
            $msg = $this->where($where)->find();
            if ($msg) {
                $info = $this->where($where)->delete();
                return ['code' => CODE_SUCCESS, 'msg' => '删除成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        } catch (\Exception $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 获取前置知识点
     * @param string $name
     * @param boolean $core_only
     * @return array ['code', 'msg', 'data']
     */
    public function getPreKnowledge($name, $core_only = false) {
        try {
            $knowledgeModel = new KnowledgeModel();
            $msg = $knowledgeModel->getSpecificKnowledge($name);
            if ($msg) {
                $where = [
                    'k.knowledge_id' => $msg['data']['id']
                ];
                if ($core_only) {
                    $where['k.is_core'] = 1;
                }
                $result = $this->alias('k')
                    ->join(['knowledge' => 'a'], 'a.id = k.pre_knowledge_id')
                    ->where($where)
                    ->field(['a.id', 'a.name', 'k.is_core'])
                    ->select();
                return ['code' => CODE_SUCCESS, 'msg' => '查询成功', 'data' => $result];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '知识点不存在', 'data' => $msg];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 切换是否为必须前置
     * @param array $data['name', 'pre_name']
     * @return array ['code', 'msg', 'data']
     */
    public function switchCore($data) {
        try {
            $knowledgeModel = new KnowledgeModel();
            $msg = $knowledgeModel->getKnowledgePairID($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                $where = [ 'id' => $msg['id']];
                if ($msg['is_core'] == 0) {
                    $updateData = ['is_core' => 1];
                } else {
                    $updateData = ['is_core' => 0];
                }
                $info = $this->where($where)->update($updateData);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 设置为必须前置
     * @param array $data ['name', 'pre_name']
     * @return array ['code', 'msg', 'data']
     */
    public function setCore($data) {
        try {
            $knowledgeModel = new KnowledgeModel();
            $msg = $knowledgeModel->getKnowledgePairID($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                $where = [ 'id' => $msg['id']];
                $updateData = ['is_core' => 1];
                $info = $this->where($where)->update($updateData);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }

    /**
     * @usage 取消设置为必须前置
     * @param array $data ['name', 'pre_name']
     * @return array ['code', 'msg', 'data']
     */
    public function unsetCore($data) {
        try {
            $knowledgeModel = new KnowledgeModel();
            $msg = $knowledgeModel->getKnowledgePairID($data);
            if ($msg['code'] == CODE_ERROR) {
                return $msg;
            } else {
                $id_pair = $msg['data'];
            }
            $msg = $this->where($id_pair)->find();
            if ($msg) {
                $where = [ 'id' => $msg['id']];
                $updateData = ['is_core' => 0];
                $info = $this->where($where)->update($updateData);
                return ['code' => CODE_SUCCESS, 'msg' => '更新成功', 'data' => $info];
            } else {
                return ['code' => CODE_ERROR, 'msg' => '关系不存在', []];
            }
        } catch (DbException $e) {
            return ['code' => CODE_ERROR, 'msg' => '数据库异常', 'data' => $e->getMessage()];
        }
    }
}