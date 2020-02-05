<?php


namespace app\oj\controller;


use app\oj\model\ContestModel;
use app\oj\model\ContestUserModel;
use app\oj\model\DiscussModel;
use app\oj\model\ReplyModel;
use app\oj\validate\ContestValidate;
use app\oj\validate\DiscussValidate;
use app\oj\validate\ReplyValidate;
use think\Controller;
use think\facade\Session;

class Discuss extends Controller
{
    public function add_discuss()
    {
        $discuss_model = new DiscussModel();
        $discuss_validate = new DiscussValidate();
        $req = input('post.');

        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        $result = $discuss_validate->scene('add_discuss')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $discuss_validate->getError(), '');
        }

        /**
         *  add discuss
         *  if the user is administrator, the discuss is a notice
         */
        $identity = Session::get('identity');
        $stauts = 0;
        if($identity === ADMINISTRATOR){
            $stauts = 8; // notice status equals 8
        }
        $data = array(
            'contest_id' => isset($req['contest_id']) ? $req['contest_id'] : 0,
            'problem_id' => $req['problem_id'],
            'user_id' => $user_id,
            'content' => $req['content'],
            'title' => $req['title'],
            'status' => $stauts
        );
        $resp = $discuss_model->add_discuss($data);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function add_reply()
    {
        $reply_model = new ReplyModel();
        $discuss_model = new DiscussModel();
        $reply_validate = new ReplyValidate();
        $req = input('post.');

        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $result = $reply_validate->scene('add_reply')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $reply_validate->getError(), '');
        }

        /**
         * judge identity
         * if the user is administrator, this discuss will be changed status
         */
        $identity = Session::get('identity');
        if($identity === ADMINISTRATOR){
            $data = array(
                'id' => $req['id'],
                'status' => 1,
            );
            $discuss_model->update_discuss($data);
        }
        $data = array(
            'discuss_id' => $req['id'],
            'user_id' => $user_id,
            'content' => $req['content'],
        );
        $resp = $reply_model->add_reply($data);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function getAllTopic()
    {
        $discuss_model = new DiscussModel();
        // TODO 上redis
        $req = input('post.');
        $resp = $discuss_model->get_all_topic(isset($req['contest']) ? 1 : 0, isset($req['page']) ? $req['page'] : 0);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function getAllDiscuss()
    {
        // TODO 上redis
        $discuss_model = new DiscussModel();

        // get all discuss
        $req = input('post.');
        if(!isset($req['contest_id']) && !isset($req['problem_id'])){
            return apiReturn(CODE_ERROR, '未填写id', '');
        }

        $resp = $discuss_model->get_all_discuss(isset($req['contest_id']) ? $req['contest_id'] : 0,
            isset($req['problem_id']) ? $req['problem_id'] : 0,
            isset($req['page']) ? $req['page'] : 0);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function getTheDiscuss()
    {
        $discuss_model = new DiscussModel();
        $reply_model = new ReplyModel();
        $req = input('post.');
        if(!isset($req['discuss_id'])){
            return apiReturn(CODE_ERROR, '未填写讨论id', '');
        }
        // get discuss and it's replies
        $resp = $discuss_model->get_the_discuss($req['discuss_id']);
        if(empty($resp['data'])){
            return apiReturn(CODE_ERROR, '没有这个讨论', '');
        }
        $data['discuss'] = $resp['data'];// discuss
        $resp = $reply_model->get_the_discuss($req['discuss_id'], isset($req['page']) ? $req['page'] : 0);
        $data['reply'] = $resp['data'];// reply

        return apiReturn($resp['code'], $resp['msg'], $data);
    }

    public function getUserDiscuss()
    {
        $discuss_model = new DiscussModel();
        $req = input('post.');

        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        if(!isset($req['contest_id'])){
            return apiReturn(CODE_ERROR, '未填写比赛id', '');
        }
        $contest_id = $req['contest_id'];

        // check this user authority
        $info = $this->checkContest($contest_id, $user_id);
        if($info['code'] !== CODE_SUCCESS){
            return apiReturn($info['code'], $info['msg'], $info['data']);
        }
        $resp = $discuss_model->get_user_discuss($user_id, $contest_id, isset($req['page']) ? $req['page'] : 0);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 检查参加比赛状态
     */
    private function checkContest($contest_id, $user_id)
    {
        $contest_user_model = new ContestUserModel();
        return $contest_user_model->searchUser($contest_id, $user_id);
    }
}