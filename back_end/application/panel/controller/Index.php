<?php


namespace app\panel\controller;


class Index extends Base
{

    /* 页面 */
    public function index()
    {
        return $this->fetch();
    }
}