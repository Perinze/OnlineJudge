<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use app\index\model\SignModel;

class Sign extends Controller
{
    public function contract()
    {
        return $this->fetch();
    }

    public function addsign()
    {
        $info = Request::instance()->get();
        $created = time();
        $data = array(
            'name' => $info['name'],
            'sex' => $info['sex'],
            'class' => $info['class'],
            'cardNo' => $info['cardNo'],
            'class' => $info['class'],
            'date' => $info['date'],
            'qq' => $info['qq'],
            'tel' => $info['tel'],
            'dorm' => $info['dorm'],
            'status' => 0,
            'content' => $info['content'],
            'create_time' => $created,
            'update_time' => $created
        );
        if($finish){
            return apiReturn(-1, "报名已经结束", '', 200);
        }
        else{
            $item = new SignModel();
            $where = ['cardNo' => $data['cardNo']];
            $temp = $item->getsign($where);
            if($temp && $temp['update_time'] + 1000 > $created){
                return apiReturn(-1, "不要频繁提交", '', 200);
            }
            $rel = $item->addsign($data);
            return apiReturn($rel['code'], $rel['msg'], $rel['data'], 200);
        }
    }
}