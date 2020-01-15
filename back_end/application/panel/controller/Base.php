<?php


namespace app\panel\controller;


use think\Controller;
use think\Session;

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
            'c' => '',
            'a' => 'index',
            'title' => '博客内容',
            'icon' => '',
            'child' => array(
                array(
                    'c' => 'blog',
                    'a' => 'blog_tag',
                    'title' => '博客标签'
                ),
                array(
                    'c' => 'blog',
                    'a' => 'add',
                    'title' => '添加博客'
                ),
                array(
                    'c' => 'blog',
                    'a' => 'index',
                    'title' => '博客列表'
                ),
            )
        ),
        array(
            'c' => 'activity',
            'a' => 'index',
            'title' => '活动内容',
            'icon' => '',
            'child' => array(
                array(
                    'c' => 'activity',
                    'a' => 'add',
                    'title' => '添加活动'
                ),
                array(
                    'c' => 'activity',
                    'a' => 'index',
                    'title' => '活动列表'
                ),
            )
        ),
        array(
            'c' => 'sign',
            'a' => 'index',
            'title' => '活动报名',
            'icon' => '',
            'child' => array(
                array(
                    'c' => 'activitySign',
                    'a' => 'index&activity_id=1',
                    'title' => '旧书圆新梦'
                ),
                array(
                    'c' => 'activitySign',
                    'a' => 'index&activity_id=2',
                    'title' => '义务家教'
                ),
                array(
                    'c' => 'activitySign',
                    'a' => 'index&activity_id=3',
                    'title' => '义务卖报'
                ),
                array(
                    'c' => 'activitySign',
                    'a' => 'index&activity_id=4',
                    'title' => '网页大赛'
                ),
                array(
                    'c' => 'activitySign',
                    'a' => 'index&activity_id=4',
                    'title' => '演讲比赛'
                ),
                array(
                    'c' => 'activitySign',
                    'a' => 'index&activity_id=5',
                    'title' => '义务维修'
                ),
            )
        ),
        array(
            'c' => 'sign',
            'a' => 'index',
            'title' => '报名信息',
            'icon' => '',
            'child' => array(
                array(
                    'c' => 'sign',
                    'a' => 'index&id=1',
                    'title' => '服务队'
                ),
                array(
                    'c' => 'sign',
                    'a' => 'index&id=2',
                    'title' => '外联部'
                ),
                array(
                    'c' => 'sign',
                    'a' => 'index&id=3',
                    'title' => '宣传部'
                ),
                array(
                    'c' => 'sign',
                    'a' => 'index&id=4',
                    'title' => '办公室'
                ),
                array(
                    'c' => 'sign',
                    'a' => 'index&id=5',
                    'title' => '策划部'
                ),
            )
        ),
        array(
            'c' => 'character',
            'a' => 'index',
            'title' => '自强人物',
            'icon' => '',
            'child' => array(
                array(
                    'c' => 'character',
                    'a' => 'manage',
                    'title' => '人物管理'
                ),
            )
        ),
        array(
            'c' => 'user',
            'a' => 'index',
            'title' => '用户管理',
            'icon' => '',
            'child' => array(
                array(
                    'c' => 'user',
                    'a' => 'mine',
                    'title' => '个人信息'
                ),
                array(
                    'c' => 'user',
                    'a' => 'upload_avatar',
                    'title' => '头像上传'
                ),
                array(
                    'c' => 'user',
                    'a' => 'ziqiang',
                    'title' => '用户列表'
                ),
            )
        ),
        array(
            'c' => 'user',
            'a' => 'calendar',
            'title' => '生日日历',
            'icon' => '',
            'child' => array()
        ),
    );

    /**
     * 登录检测
     */
    protected function _initialize()
    {

    }
}