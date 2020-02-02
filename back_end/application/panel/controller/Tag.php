<?php


namespace app\panel\controller;


use app\panel\model\TagModel;

class Tag extends Base
{
    /* 接口 */
    public function getAllTag()
    {
        $tag_model = new TagModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'name');
        $resp = $tag_model->getAllTag($where['where'], $where['limit'], $where['offset']);
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $tag_model);
    }

    public function getAllTags()
    {
        $tag_model = new TagModel();
        $resp = $tag_model->getAllTag(['status' => 1], 100, 0);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    public function getTheTag()
    {
        $tag_model = new TagModel();
        $req = input('post.');
        if(!isset($req['id'])){
            return apiReturn(CODE_ERROR, '请填写id', '');
        }
        $resp = $tag_model->getTheTag($req['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function addTag()
    {
        $tag_model = new TagModel();
        $req = input('post.');
        if(!isset($req['name'])){
            return apiReturn(CODE_ERROR, '请填写标签名字', '');
        }
        $resp = $tag_model->addTag($req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function editTag()
    {
        $tag_model = new TagModel();
        $req = input('post.');
        if(!isset($req['id'])){
            return apiReturn(CODE_ERROR, '请填写标签序号', '');
        }
        $resp = $tag_model->editTag($req);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function deleTag()
    {
        $tag_model = new TagModel();
        $req = input('post.');
        if(!isset($req['id'])){
            return apiReturn(CODE_ERROR, '请填写标签序号', '');
        }
        $resp = $tag_model->deleTag($req['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /* 页面 */
    public function index()
    {
        return $this->fetch();
    }

    public function info()
    {
        $req = input('get.');
        $id = isset($req['id']) ? $req['id'] : 0;
        $this->assign('id', $id);
        return $this->fetch();
    }
}