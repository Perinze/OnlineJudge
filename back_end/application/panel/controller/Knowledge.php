<?php


namespace app\panel\controller;


use app\panel\model\KnowledgeModel;
use app\panel\model\KnowledgeRelationModel;

class Knowledge extends Base
{
    public function test() {
        $knowledgeModel = new KnowledgeModel();
        $relationModel = new KnowledgeRelationModel();
        $data = [
            'name' => 'graph',
            'pre_name'  => 'tree'
        ];
        //$msg = $knowledgeModel->addKnowledge($data);
        //$msg = $relationModel->addRelation($data);
        //$msg = $knowledgeModel->deleteKnowledge($data);
        //$msg = $relationModel->deleteRelation($data);
        //$msg = $relationModel->switchCore($data);
        //$msg = $relationModel->deleteRelationByID(4);
        $msg = $relationModel->getPreKnowledge('graph');
        return apiReturn(200, 'ok', $msg);
    }

    public function index()
    {
        return $this->fetch('index');
    }
}