<?php


namespace app\panel\controller;


use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    // 后台菜单栏
    public $menu = array(
        array(
            'c' => 'index',
            'a' => 'index',
            'title' => '控制台',
            'icon' => 'dashboard',
            'child' => array()
        ),
        array(
            'c' => 'problem',
            'a' => 'index',
            'title' => '题目列表',
            'icon' => '',
            'child' => array()
        ),
        array(
            'c' => 'contest',
            'a' => 'index',
            'title' => '比赛列表',
            'icon' => '',
            'child' => array()
        ),
        array(
            'c' => 'user',
            'a' => 'index',
            'title' => '用户列表',
            'icon' => '',
            'child' => array()
        ),
        array(
            'c' => 'knowledge',
            'a' => 'index',
            'title' => '知识树列表',
            'icon' => '',
            'child' => array()
        ),
    );

    /**
     * 登录检测
     */
    public function __construct()
    {
        parent::__construct();
//        halt(session('identity'));
        if (!Session::has('user_id')) {
            $this->redirect(config('wutoj_config.oj_url'));
        }
        if (Session::get('identity') !== ADMINISTRATOR){
            $this->redirect(config('wutoj_config.oj_url'));
        }
        $this->assign('realname', session('nick'));
        $this->assign('menu', $this->menu);
    }
}