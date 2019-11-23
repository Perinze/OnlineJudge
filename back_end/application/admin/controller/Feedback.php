<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/11/6
 * Time: 13:28
 */
namespace app\admin\controller;

use app\admin\model\FeedbackProblemModel;
use function simplehtmldom_1_5\file_get_html;
use think\facade\Config;
use app\admin\model\FeedbackModel;
use app\admin\model\FeedbackReplyModel;
use app\admin\model\FeedbackTypeModel;
use app\admin\validate\FeedbackValidate;
use app\admin\validate\FeedbackTypeValidate;
use app\admin\validate\FeedbackProblemValidate;
use think\facade\Session;

class Feedback extends Base
{
    public function index()
    {
        return $this->fetch();
    }
    /**
     * @return \think\response\Json
     * 获取反馈信息列表
     */
    public function get_list()
    {
        $feedback = new FeedbackModel();
        $resp = $feedback->get_all_list();
        $data['data'] = empty($resp['data']) ? array() : $resp['data'];
        $data['recordsTotal'] = count($data['data']);
        $data['recordsFiltered'] = count($data['data']);
        echo json_encode($data);
    }

    /**
     *
     * 获取删除的反馈列表
     */
    public function get_delete_list()
    {
        $feedback = new FeedbackModel();
        $where['del'] = 1;
        $resp = $feedback->get_the_list($where);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @return \think\response\Json
     * 获取反馈类型列表
     */
    public function get_all_type()
    {
        $feedback_type = new FeedbackTypeModel();
        $resp = $feedback_type->get_all_type();
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function get_the_type()
    {
        $data = input('post.');
        $feedback_type = new FeedbackTypeModel();
        $feedback_validate = new FeedbackValidate();
        $rel = $feedback_validate->scene('get_the_type')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
        }
        $resp = $feedback_type->get_the_type($data['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    public function problem()
    {
        $data = input('get.');
        $this->assign('rel', $data);
        return $this->fetch();
    }
    public function get_all_problem()
    {
        $data = input('get.');
        $feedback_type = new FeedbackProblemModel();
//        $feedback_validate = new FeedbackValidate();
//        $rel = $feedback_validate->scene('get_the_type')->check($data);
//        if ($rel != VALIDATE_PASS) {
//            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
//        }
        $resp = $feedback_type->get_all_problem(isset($data['type']) ? $data['type'] : 0);
        //halt($resp);
        $resp_data['data'] = empty($resp['data']) ? array() : $resp['data'];
        $resp_data['recordsTotal'] = count($resp_data['data']);
        $resp_data['recordsFiltered'] = count($resp_data['data']);
        echo json_encode($resp_data);
        //return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    public function get_the_problem()
    {
        $data = input('get.');
        $feedback_problem = new FeedbackProblemModel();
        $feedback_validate = new FeedbackValidate();
        $rel = $feedback_validate->scene('get_the_problem')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
        }
        $resp = $feedback_problem->get_the_problem($data['id']);
        $this->assign('rel', $resp['data']);
        return $this->fetch('feedback/edit_problem');
        //return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    /**
     *
     * 获取删除的反馈类型列表
     */
    public function get_delete_type()
    {
        $feedback_type = new FeedbackTypeModel();
        $where['del'] = 1;
        $resp = $feedback_type->get_the_type($where);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @return \think\response\Json
     * 查看单个反馈信息
     */
    public function look_feedback()
    {
        $data = input("get.");
        $feedback_validate = new FeedbackValidate();
        $rel = $feedback_validate->scene('look_feedback')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
        }
        //获取反馈信息id号，根据id号返回对应数据
        $id = $data['id'];
        $feedback_model = new FeedbackModel();
        $where = [
            'id' =>	$id,
        ];
        $resp = $feedback_model->get_the_list($where);
        $resp['data']['img_url'] = json_decode($resp['data']['img_url'], false);
        if(isset($resp['data']['type'])){
            $resp['data']['type'] = $resp['data']['type'] == 1 ? 'ios' : 'android';
        }
        $realname = empty(Session::get('panel_user.realname', 'iwut'))
            ?'匿名':Session::get('panel_user.realname', 'iwut');
        $this->assign('rel', $resp['data']);
        $this->assign('realname', $realname);
        $this->assign('id', $data['id']);
        return $this->fetch();
        //return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * @return \think\response\Json
     * 后台人员回复提问
     */
    public function add_reply()
    {
        $data = input("post.");
        $feedback_validate = new FeedbackValidate();
        $rel = $feedback_validate->scene('add_reply')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
        }
        $id =$data['id'];
        $reply_model = new FeedbackReplyModel();
        $reply_data = array(
            'feedback_id' => $id,
            'content' =>$data['content'],
            'reply_person' => $data['reply_person'],
        );
        $user_model = new FeedbackModel();
        $where['id'] = $id;
        $resp_data = $user_model->get_the_list($where);
        $res = file_get_contents("https://push.wutnews.net/portal/sms.php?user=".$resp_data['data']['phone']."&summary=".urlencode($data['content']));
        if(isset($res['message']) && $res['message'] == '成功'){
            return apiReturn(CODE_ERROR, '发送短信失败', '');
        }
        $resp = $reply_model->add_reply($reply_data);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     *
     * 后台人员删除回复
     */
    public function delete_reply()
    {
         $data = input("post.");
        $feedback_validate = new FeedbackValidate();
        $rel = $feedback_validate->scene('delete_reply')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
        }
        $reply_model = new FeedbackReplyModel();
        $resp = $reply_model->delete_reply($data['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     *
     * 后台人员恢复回复内容
     */
    public function recover_reply()
    {
        $data = input("post.");
        $feedback_validate = new FeedbackValidate();
        $rel = $feedback_validate->scene('recover_reply')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
        }
        $reply_model = new FeedbackReplyModel();
        $resp = $reply_model->recover_reply($data['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    /**
     *
     * 后台人员删除反馈类别
     */
    public function delete_type()
    {
        $data = input("post.");
        $feedback_type_validate = new FeedbackTypeValidate();
        $rel = $feedback_type_validate->scene('delete_type')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_type_validate->getError(), '');
        }
        $type_model = new FeedbackTypeModel();
        $resp = $type_model->delete_type($data['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     *
     * 后台人员恢复反馈类别
     */
    public function recover_type()
    {
        $data = input("post.");
        $feedback_type_validate = new FeedbackTypeValidate();
        $rel = $feedback_type_validate->scene('recover_type')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_type_validate->getError(), '');
        }
        $type_model = new FeedbackTypeModel();
        $resp = $type_model->recover_type($data['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    public function add_type()
    {
        return $this->fetch();
    }
    /**
     *
     * 后台人员添加反馈类别
     */
    public function add_the_type()
    {
        $data = input("post.");
        $feedback_type_validate = new FeedbackTypeValidate();
        $rel = $feedback_type_validate->scene('add_the_type')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_type_validate->getError(), '');
        }
        $type_model = new FeedbackTypeModel();
        $type_arr = array(
            'content' => $data['content'],
            'sort' => $data['sort'],
            'count' => 0,
        );
        $resp = $type_model->add_type($type_arr);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    public function edit_type()
    {
        return $this->fetch();
    }
    /**
     *
     * 后台人员更新反馈类别
     */
    public function update_type()
    {
        $data = input("post.");
        $feedback_type_validate = new FeedbackTypeValidate();
        $rel = $feedback_type_validate->scene('update_type')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_type_validate->getError(), '');
        }
        $type_model = new FeedbackTypeModel();
        $type_arr = array(
            'id' => $data['id'],
            'content' => $data['content'],
        );
        $resp = $type_model->update_type($type_arr);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function update_type_sort()
    {
        $data = input("post.");
        $feedback_type_validate = new FeedbackTypeValidate();
        $rel = $feedback_type_validate->scene('update_type_sort')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_type_validate->getError(), '');
        }
        $type_model = new FeedbackTypeModel();
        $i = 0;
        $resp = array();
        foreach ($data as $value){
            $type_arr[$i++] = array(
                'id' => $value['id'],
                'sort' => $value['sort'],
            );
            $resp = $type_model->update_sort($type_arr);
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
    public function add_problem()
    {
        return $this->fetch();
    }
    public function add_the_problem()
    {
        $data = input("post.");
        $feedback_validate = new FeedbackProblemValidate();
        $rel = $feedback_validate->scene('add_the_problem')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
        }
        $problem_model = new FeedbackProblemModel();
        $problem_arr = array(
            'problem' => $data['problem'],
            'content' => $data['content'],
            'type' => $data['type'],
        );
        $resp = $problem_model->add_problem($problem_arr);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function delete_problem()
    {
        $data = input("get.");
        $feedback_validate = new FeedbackProblemValidate();
        $rel = $feedback_validate->scene('delete_problem')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
        }
        $problem_model = new FeedbackProblemModel();

        $resp = $problem_model->delete_problem($data['id']);
        return $this->fetch('feedback/problem');
        //return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function update_problem()
    {
        $data = input("post.");
        $feedback_validate = new FeedbackProblemValidate();
        $rel = $feedback_validate->scene('update_problem')->check($data);
        if ($rel != VALIDATE_PASS) {
            return apiReturn(CODE_PARAM_ERROR, $feedback_validate->getError(), '');
        }
        $problem_model = new FeedbackProblemModel();

        $resp = $problem_model->delete_problem($data['id']);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}
