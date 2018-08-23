<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/8/22
 * Time: 下午7:35
 */
namespace app\index\controller;

use app\index\model\NoticeModel;
use app\index\model\UserModel;
use think\Controller;

class Panel extends Controller{
    public function index()
    {
        $this->assign('type','index');
        return $this->fetch('panel/index');
    }

    public function notice()
    {
        $user = new UserModel();
        $notice = new NoticeModel();
        $list = $notice->getnotcielist()['data'];
        $cnt=0;
        foreach($list as $v){
            $v['status']=$v['status']==1?'Dispaly':'Not Display';
            $v['user']=$user->getinfo($v['user'])['userName'];
            $v['num']=($cnt++);
        }

        $this->assign('list',$list);
        $this->assign('type','notice');
        return $this->fetch('panel/notice');
    }

    public function user()
    {
        $user = new UserModel();
        $list = $user->getuserinfo();
        $cnt=0;
        foreach($list as $v) {
            $v['userStat']=$v['userStat']==0?'退役':'现役';
            $v['userGender']=$v['userGender']==0?'女':'男';
            switch($v['userType'])
            {
                case -1:$v['userType']='黑名单';break;
                case 0:$v['userType']='会员';break;
                case 1:$v['userType']='正式成员';break;
                case 2:$v['userType']='管理员';break;
            }
            $v['num']=($cnt++);
            $list[$cnt-1]=$v;
        }

        $this->assign('list',$list);
        $this->assign('type','user');
        return $this->fetch('panel/user');
    }

    public function recruit()
    {
        $this->assign('type','recruit');
        return $this->fetch('panel/recruit');
    }

    public function problem()
    {
        $this->assign('type','problem');
        return $this->fetch('panel/problem');
    }
}