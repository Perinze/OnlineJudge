<?php

namespace app\oj\controller;

use app\index\widget\Token;
use app\oj\model\KnowledgeModel;
use app\oj\validate\KnowledgeValidate;
use think\response\Json;

class Knowledge extends Base {

    /**
     * @usage 获取所有知识点
     * @method get
     * @param void
     * @return json
     */
    public function getAllKnowledge() {
        $knowledgeModel = new KnowledgeModel();
        $resp = $knowledgeModel->getKnowledge("");
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 模糊查询知识点
     * @method get
     * @param string knowledge
     * @return json
     */
    public function getKnowledgeByKey() {
        $req = input('get.');
        $knowledgeModel = new KnowledgeModel();
        $knowledge = isset($data['knowledge'])?$req['knowledge']:'';
        $resp = $knowledgeModel->getKnowledge($knowledge);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 精确查询知识点
     * @method get
     * @param string knowledge
     * @return json
     */
    public function getSpecificKnowledge() {
        $req = input('get.');
        $knowledgeModel = new KnowledgeModel();
        $knowledge = isset($data['knowledge'])?$req['knowledge']:'';
        $resp = $knowledgeModel->getSpecificKnowledge($knowledge);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 添加知识点
     * @method post
     * @param string knowledge
     * @return json
     */
    public function addKnowledge() {
        $req = input('post.');
        $knowledgeModel = new KnowledgeModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('add_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'name' => $req['knowledge']
        ];
        $resp = $knowledgeModel->addKnowledge($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }

    /**
     * @usage 删除知识点
     * @method post
     * @param string knowledge
     * @return json
     */
    public function deleteKnowledge() {
        $req = input('post.');
        $knowledgeModel = new KnowledgeModel();
        $knowledgeValidate = new KnowledgeValidate();
        $result = $knowledgeValidate->scene('delete_knowledge')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $knowledgeValidate->getError(), '');
        }
        $data = [
            'name' => $req['knowledge']
        ];
        $resp = $knowledgeModel->deleteKnowledge($data);
        return apiReturn($resp['code'], $resp['msg'], '');
    }
}