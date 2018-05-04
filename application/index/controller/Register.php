<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 上午9:45
 */
namespace app\index\Controller;

class Register extends Base{
    public function registe()
    {
        if(!$this->checkToken(input('post.token')))
        {
            $ret = array('errCode'=>403,'errMsg'=>'token error','data'=>null);
            return json($ret);
        }
        
    }
}