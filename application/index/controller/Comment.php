<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/8/6
 * Time: 下午10:18
 */
namespace app\index\controller;

require_once "Base.php";

class Comment extends Base{
    public function addComment()
    {
        if($this->checkToken(input('post.token'))!==true)
        {
            $ret = array('errCode'=>403,'errMsg'=>'token error','data'=>null);
            return json($ret);
        }

        if(session('userId')==null)
        {
            $ret = array('errCode'=>405,'errMsg'=>'用户未登录','data'=>null);
            return json($ret);
        }

        //TODO add commentFunction
    }
}