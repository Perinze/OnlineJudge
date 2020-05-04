<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/2/28
 * Time: 15:33
 */

namespace app\oj\controller;

use app\oj\model\ContestModel;
use app\oj\model\GroupModel;
use app\oj\model\GroupproblemModel;
use app\oj\model\KnowledgeModel;
use app\oj\model\ProblemModel;
use app\oj\model\UsergroupModel;
use app\oj\validate\ContestValidate;
use app\oj\validate\GroupValidate;
use app\panel\model\KnowledgeUserModel;
use think\Controller;
use think\facade\Session;


class Group extends Controller
{

    // uncheck
    /**
     * 获取所有团队
     */
    public function get_all_group()
    {
        $group_model = new GroupModel();
        $req = input('post.');
        $resp = $group_model->get_all_group(isset($req['page']) ? $req['page'] : 0);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 获取一个用户加入的所有团队
     */
    public function user_get_all_group()
    {
        $usergroup_model = new UsergroupModel();
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $req = input('post.');
        $resp = $usergroup_model->find_group($session, isset($req['page']) ? $req['page'] : 0);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 获取某个团队的基本信息
     */
    public function get_the_group()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();
        $group_model = new GroupModel();
        $knowledge_model = new KnowledgeModel();

        $req = input('post.');
        $result = $group_validate->scene('get_the_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $resp = $usergroup_model->find_user($req['group_id']);// find all users who joined this group
        $resp1 = $group_model->get_the_group($req['group_id']);// get this group's info
        $user_data = $resp['data'];
        $group_data = $resp1['data'];
        for ($i = 0; $i < sizeof($user_data); $i++) {
            $user_data[$i]['point'] = $knowledge_model->getUserKnowledgePoint($user_data[$i]['user_id'])['data'];
        }
        return apiReturn($resp['code'], $resp['msg'], array(
            'user' => $user_data,
            'group' => $group_data
        ));
    }

    /**
     * 添加一个团队
     * TODO 限制一个用户可创建团队数目
     */
    public function add_group()
    {
        $group_validate = new GroupValidate();
        $group_model = new GroupModel();

        // check login
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        // add
        $req = input('post.');
        $result = $group_validate->scene('add_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $user_id = isset($req['user_id']) ? $req['user_id'] : array();
        if(!is_array($user_id)){
            return apiReturn(CODE_ERROR, '添加用户格式错误', '');
        }
        $resp = $group_model->newGroup(array(
            'group_name' => $req['group_name'],
            'avatar' => isset($req['avatar']) ? $req['avatar'] : '',
            'desc' => $req['desc'],
            'join_code' => isset($req['join_code']) ?  strlen($req['join_code']) > 16 ? substr($req['join_code'], 0, 16) : $req['join_code'] : '',
            'group_creator' => $session,
        ), $user_id);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 加入一个团队
     */
    public function join_group()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();
        $group_model = new GroupModel();
        $session = Session::get('user_id');

        // check login
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $req = input('post.');
        $result = $group_validate->scene('join_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $join_code = $group_model->get_the_group($req['group_id']);
        if($join_code['code'] !== CODE_SUCCESS){
            return apiReturn($join_code['code'], $join_code['msg'], $join_code['data']);
        }
        if($join_code['data']['join_code'] !== $req['join_code']){
            return apiReturn(CODE_ERROR, '加群码错误', '');
        }
        $resp = $usergroup_model->addRelation($req['group_id'], $session, 0);
        if(strpos($resp['data'], 'Duplicate entry') !== false){
            $resp['msg'] = '已在群组内';
            $resp['data'] = '';
        }
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 退出团队
     */
    public function out_group()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();

        // check login
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        $req = input('post.');
        $result = $group_validate->scene('out_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $resp = $usergroup_model->deleRelation($req['group_id'], $session['user_id']);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    /**
     * 管理员同意一个用户的加入申请
     */
    public function accept()
    {
        $group_validate = new GroupValidate();
        $usergroup_model = new UsergroupModel();
        $group_model = new GroupModel();

        // check login
        $session = Session::get('user_id');
        if (empty($session)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        $req = input('post.');
        $result = $group_validate->scene('accept_group')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $group_validate->getError(), '');
        }
        $resp = $group_model->get_the_group($req['group_id']);
        if ($resp['code'] !== CODE_SUCCESS) {
            return apiReturn($resp['code'], $resp['msg'], $resp['data']);
        }
        if ($resp['data']['group_creator'] !== $session['user_id']) {// TODO 团队管理员权限
            return apiReturn(CODE_ERROR, '你没有权限', '');
        }
        $resp = $usergroup_model->addRelation($req['group_id'], $req['user_id'], 0);

        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }


    public function addContest()
    {
        $contest_model = new ContestModel();
        $user_group_model = new UsergroupModel();
        $contest_validate = new ContestValidate();

        $req = input('post.');
        $result = $contest_validate->scene('addContest')->check($req);
        if ($result !== true) {
            return apiReturn(CODE_ERROR, $contest_validate->getError(), '');
        }
        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }

        $resp = $user_group_model->searchRelation($req['group_id'], $user_id);
        if($resp['code'] !== CODE_SUCCESS || $resp['data']['identity'] === MEMBER){
            return apiReturn($resp['code'], '你不是该团队中的管理员', '');
        }
        if(isset($req['colors']) && !is_array($req['colors'])){
            return apiReturn(CODE_ERROR, '数据格式错误', '');
        }
        if(!isset($req['problems']) && !is_array($req['problems'])){
            return apiReturn(CODE_ERROR, '数据格式错误', '');
        }
        foreach ($req['problems'] as $item){

        }
        $resp = $contest_model->newContest(array(
            'contest_name' => $req['contest_name'],
            'begin_time' => $req['begin_time'],
            'end_time' => $req['end_time'],
            'frozen' => $req['frozen'],
            'colors' => json_encode(isset($req['colors']) ? $req['colors'] : array()),
            'problems' => json_encode($req['problems']),
        ));
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function addGroupProblem()
    {
        $problem_model = new ProblemModel();
        $user_group_model = new UsergroupModel();
        $group_problem_model = new GroupproblemModel();

        $req = input('post.');

        if(!isset($req['problems']) || !is_array($req['problems'])){
            return apiReturn(CODE_ERROR, '未填写题目列表或格式错误','');
        }
        if(!isset($req['group_id'])){
            return apiReturn(CODE_ERROR, '未填写团队id','');
        }

        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $group_id = $req['group_id'];
        $resp = $user_group_model->searchRelation($group_id, $user_id);
        if($resp['code'] !== CODE_SUCCESS || $resp['data']['identity'] === MEMBER){
            return apiReturn(CODE_ERROR, '你不是该团队中的管理员', '');
        }
        $flag = true;
        $msg = '成功';
        foreach ($req['problems'] as $item){
            $resp = $problem_model->searchProblemById($item);
            if($resp['code'] !== CODE_SUCCESS || $resp['data']['status'] !== USING){
                continue;
            }
            $resp = $group_problem_model->addRelation($group_id, $item);
            if($flag && strpos($resp['data'], 'Duplicate entry') !== false){
                $msg = '部分题目添加失败';
            }
        }

        return apiReturn($resp['code'], $msg, '');
    }

    public function getAllProblem()
    {
        $user_group_model = new UsergroupModel();
        $group_problem_model = new GroupproblemModel();

        $req = input('post.');

        if(!isset($req['group_id'])){
            return apiReturn(CODE_ERROR, '未填写团队id','');
        }

        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $group_id = $req['group_id'];
        $resp = $user_group_model->searchRelation($group_id, $user_id);
        if($resp['code'] !== CODE_SUCCESS){
            return apiReturn(CODE_ERROR, '你不是该团队中的成员', '');
        }

        $resp = $group_problem_model->getAllProblem($group_id, isset($req['page']) ? $req['page'] : 0);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }

    public function getAllContest()
    {
        $user_group_model = new UsergroupModel();
        $contest_model = new ContestModel();
        $req = input('post.');

        if(!isset($req['group_id'])){
            return apiReturn(CODE_ERROR, '未填写团队id','');
        }

        // check login
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return apiReturn(CODE_ERROR, '未登录', '');
        }
        $group_id = $req['group_id'];
        $resp = $user_group_model->searchRelation($group_id, $user_id);
        if($resp['code'] !== CODE_SUCCESS){
            return apiReturn(CODE_ERROR, '你不是该团队中的成员', '');
        }

        $resp = $contest_model->getAllGroupContest($group_id, isset($req['page']) ? $req['page'] : 0);
        return apiReturn($resp['code'], $resp['msg'], $resp['data']);
    }
}