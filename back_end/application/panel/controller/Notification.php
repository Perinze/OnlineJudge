<?php


namespace app\panel\controller;


use app\common\model\NotificationModel;

class Notification extends Base
{

    public function getAllNotification()
    {
        $notification_model = new NotificationModel();
        $req = input('post.aoData');
        $where = aoDataFormat($req, 'contest_id');
        $resp = $notification_model->getAllNotification($where['where'], $where['limit'], $where['offset']);
        echo datatable_response($resp['code'], $where['where'], $resp['data'], $notification_model);
    }

    public function getNotificationByID()
    {
        $notification_model = new NotificationModel();
        $id = input('post.id');
        $resp = $notification_model->getNotificationByID($id);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    public function addNotification()
    {
        $notification_model = new NotificationModel();
        $req = input('post.');
        $data = [
            'title' =>  $req['title'],
            'content'   => $req['content'],
            'status'    =>  $req['status'],
            'user_id'   =>  session('user_id')
        ];
        if ($req['contest_id'] !== '') $data['contest_id'] = $req['contest_id'];
        $resp = $notification_model->addNotification($data);
        return apiReturn($resp['code'], $resp['msg'], $resp['data'], 200);
    }

    public function deleteNotification() {
        $notification_model = new NotificationModel();
        $id = input('get.id');
        $notification_model->deleteNotification($id);
        $this->redirect('/back_end/panel/notification/index');
    }

    public function changeStatus() {
        $notification_model = new NotificationModel();
        $id = input('get.id');
        $notification_model->changeNotificationStatus($id);
        $this->redirect('/back_end/panel/notification/index');
    }

    public function info()
    {
        $req = input('get.');
        $id = isset($req['id']) ? $req['id'] : 0;
        $this->assign('id', $id);
        return $this->fetch();
    }


    public function add()
    {
        return $this->fetch();
    }

    public function index()
    {
        return $this->fetch();
    }
}