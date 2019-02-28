<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/9/25
 * Time: 21:44
 */
namespace app\panel\controller;

use think\Session;

class Index extends Base
{
    public function index()
    {
        $user = Session::get('user', 'acm');
        $id = $user['id'];
        $this->assign('id', $id);
        return $this->fetch();
    }
}