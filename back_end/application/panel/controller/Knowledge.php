<?php


namespace app\panel\controller;


use app\panel\model\KnowledgeModel;
use app\panel\model\KnowledgeRelationModel;
use app\panel\model\ProblemKnowledgeModel;

class Knowledge extends Base
{
    public function test() {
        $knowledgeModel = new KnowledgeModel();
        $relationModel = new KnowledgeRelationModel();
        $problemModel = new ProblemKnowledgeModel();
        $data = [
            'problem_id' => 1001,
            'knowledge'  => 'graph'
        ];
        //$msg = $problemModel->addRelation($data);
        //$msg = $problemModel->switchCore($data);
        //$msg = $knowledgeModel->addKnowledge($data);
        //$msg = $problemModel->switchCore($data);
        //$msg = $problemModel->getKnowledgeByProblem(1001, 1);
        //$msg = $relationModel->addRelation($data);
        //$msg = $knowledgeModel->deleteKnowledge($data);
        //$msg = $relationModel->deleteRelation($data);
        //$msg = $relationModel->switchCore($data);
        //$msg = $relationModel->deleteRelationByID(4);
        //$msg = $relationModel->getPreKnowledge('graph');
        //return apiReturn(200, 'ok', $msg);
    }

    public function index()
    {
        return $this->fetch('index');
    }
}