<?php


namespace app\panel\controller;


class Knowledge extends Base
{
    /* 接口 */
    /**
     * 添加知识点
     */
    public function addKnowledge()
    {

    }

    /**
     * 删除知识点
     */
    public function deleKnowledge()
    {

    }

    /**
     * 修改知识点
     */
    public function editKnowledge()
    {

    }

    /**
     * 查询所有知识点
     */
    public function getAllKnowledge()
    {

    }

    /**
     * 查询单个知识点信息
     */
    public function getTheKnowledge()
    {

    }

    /* 页面 */
    /**
     * 添加知识点页面
     */
    public function add()
    {

    }

    /**
     * 知识点详情页面
     */
    public function info()
    {
        $req = input('get.');
        $id = isset($req['id']) ? $req['id'] : 0;
        $this->assign('id', $id);
        return $this->fetch();
    }

    /**
     * 首页
     */
    public function index()
    {
        return $this->fetch('index');
    }
}