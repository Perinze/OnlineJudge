<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/8/22
 * Time: 下午7:35
 */
namespace app\index\controller;

use app\index\model\NoticeModel;
use think\Controller;

class Panel extends Controller{
    public function index()
    {
        $this->assign('type','index');
        return $this->fetch('panel/index');
    }

    public function notice()
    {

        $notice = new NoticeModel();
        $list = $notice->getnotcielist()['data'];
        $cnt=0;
        foreach($list as $v){// TODO 数据处理
            $v['num']=($cnt++);
        }

        $this->assign('list',$list);
        $this->assign('type','notice');
        return $this->fetch('panel/notice');
    }
}