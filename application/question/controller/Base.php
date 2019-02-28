<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/9/25
 * Time: 21:45
 */
namespace app\index\controller;

use think\Controller;
use think\Session;
class Base extends Controller
{
    public function _initialize()
    {
        if(!Session::has('user', 'acm')){
            $this->redirect('https:/acmwhut.com/OnlineJudge/public/index/questiom/login');
        }
        $realname = empty(Session::get('user.id', acm))
            ?'NULL':Session::get('user.id', acm);
        $this->assign('realname', $realname);
    }
}