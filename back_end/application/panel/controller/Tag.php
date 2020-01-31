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

    public function getTheTag()
    {

    }

    public function addTag()
    {

    }

    public function editTag()
    {

    }

    public function deleTag()
    {

    }

    /* 页面 */
    public function index()
    {
        return $this->fetch();
    }

    public function info()
    {
        return $this->fetch();
    }
}