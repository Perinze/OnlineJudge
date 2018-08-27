<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/8/16
 * Time: 下午11:30
 */
namespace app\index\controller;

use app\index\model\NoticeModel;

require_once "Base.php";

class Notice extends Base{
    public function addNotice()
    {
        if($this->checkToken(input('post.token'))!==true)
        {
            $this->error('Token错误','index/Panel/notice');
        }

        if($this->checkUserType(session('userId'))<=1)
        {
            $ret = array('errCode'=>403,'errMsg'=>'没有操作权限','data'=>null);
            return json($ret);
        }

        $info = input('post.');
        $data = array(
            'title' => $info['title'],
            'href' => $info['href'],
            'time' => time(),
            'user' => session('userId'),
            'status' => $info['display']
        );
        $notice = new NoticeModel();
        $result = $notice->addnotice($data);

        if($result){
            $panel = new Panel();
            $panel->notice();
        }else{
            $this->error('发布失败','index/Panel/notice');
        }
    }

    public function getdisplaylist()
    {
        $notice = new NoticeModel();
        $info = $notice->getnotcielist(['status'=>1]);
        return json(array_values($info));
    }
}