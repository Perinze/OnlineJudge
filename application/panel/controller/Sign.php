<?php
namespace app\panel\controller;
use think\Controller;
use think\Request;
use app\panel\model\SignModel;

class Sign extends Controller
{
    public function contract()
    {
        return $this->fetch();
    }

    public function addsign()
    {
        $info = $_GET;
        $created = time();
        $data = array(
            'name' => $info['name'],
            'sex' => $info['sex'],
            'class' => $info['class'],
            'cardNo' => $info['cardNo'],
            'date' => $info['date'],
            'qq' => $info['qq'],
            'tel' => $info['tel'],
            'dorm' => $info['dorm'],
            'status' => 0,
            'create_time' => $created,
            'update_time' => $created
        );
        if(config('finish')){
            return apiReturn(-1, "报名已经结束", '', 200);
        }
        else{
            $item = new SignModel();
            $where = ['cardNo' => $data['cardNo']];
            $temp = $item->getsign($where);
//            dump($temp['data'][0]['update_time']);
            if($temp['data']){
                if(strtotime($temp['data']['update_time']) + 1000 > $created){
                    return apiReturn(-1, "不要频繁提交", '', 200);
                }
            }
            $rel = $item->addsign($data);
            return apiReturn($rel['code'], $rel['msg'], $rel['data'], 200);
        }
    }

    public function test()
    {
        dump($_GET);
    }
}