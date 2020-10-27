<?php

namespace app\oj\controller;


use app\common\model\NotificationModel;
use app\common\validate\NotificationValidate;
use app\oj\model\KnowledgeModel;
use think\db\Where;
use think\response\Json;

class Notification extends Base
{
    /**
     * @usage 获取通知
     * @method get
     * @param void
     * @return json
     */
    public function getNotification() {
        $req = input('post.');
        $notificationModel = new NotificationModel();
        if (isset($req['contest_id'])) {
            $resp = $notificationModel->getNotificationByContest($req['contest_id']);
        } else {
            $resp = $notificationModel->getPublicNotification();
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @usage 由ID获取通知
     * @method get
     * @param void
     * @return json
     */
    public function getNotificationByID() {
        $req = input('post.');
        $notificationModel = new NotificationModel();
        $notificationValidate = new NotificationValidate();
        $result = $notificationValidate->scene('getNotificationByID')->check($req);
        if ($result != VALIDATE_PASS) {
            return apiReturn(CODE_ERROR, $notificationValidate->getError(), '');
        }
        $resp = $notificationModel->getNotificationByID($req['id']);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

}