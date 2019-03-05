<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午8:24
 */
namespace app\oj\controller;

use app\oj\model\GroupModel;
use app\oj\model\PrivilegeModel;
use app\oj\model\SampleModel;
use app\oj\model\UsergroupModel;
use app\oj\model\UserModel;
use think\Controller;

/**
 * Class Test 单元测试Controller
 * @package app\oj\controller
 */
class Test extends Controller {
    public function __construct(){
        parent::__construct();
    }

    public function userModel() {
        $user = new UserModel();

        $data = [
            'nick'=>'ljw',
            'password'=>md5(base64_encode('ljwdl')),
            'desc'=>json_encode([
                'phone'=>'123123123',
                'sex'=>'female'
            ])
        ];

        $res = $user->addUser($data);
        if($res['code']==CODE_SUCCESS) {
            echo 'add success';
        }else{
            halt($res);
        }

        echo '<br>';

        $res = $user->searchUserByNick($data['nick']);
        if($res['code']==CODE_SUCCESS) {
            echo 'search name success : ';
            dump($res['data']);
        } else {
            halt($res);
        }

        $user_id = $res['data']['user_id'];

        echo '<br>';

        $res = $user->searchUserById($user_id);
        if($res['code']==CODE_SUCCESS) {
            echo 'search id success : ';
            dump($res['data']);
        }else{
            halt($res);
        }

        $new_data = [
            'nick'=>'darkkris',
            'password'=>md5(base64_encode('219909')),
            'desc'=>json_encode([
                'phone'=>'18454353727',
                'sex'=>'male'
            ])
        ];

        $res = $user->editUser($user_id, $new_data);
        if($res['code']==CODE_SUCCESS) {
            echo 'edit success';
        }else{
            halt($res);
        }

        echo '<br>';

        $res = $user->searchUserById($user_id);
        if($res['code']==CODE_SUCCESS) {
            echo 'search id success : ';
            dump($res['data']);
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $user->deleUser($user_id);
        if($res['code']==CODE_SUCCESS) {
            echo 'delete success';
        }else{
            halt($res);
        }

        echo '<br>';
    }

    public function sampleModel() {
        $problem_id = '1';
        $input = '1 2';
        $output = '1 1';

        $sample = new SampleModel();
        $res = $sample->addSample($problem_id, $input, $output);
        if($res['code']==CODE_SUCCESS) {
            echo 'add sample success';
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $sample->searchSampleByProblemID($problem_id);
        if($res['code']==CODE_SUCCESS){
            echo 'search pid success : <br>';
            dump($res['data']);
        }else{
            halt($res);
        }
        echo '<br>';

        $sample_id = '';
        foreach($res['data'] as $key=>$value){
            $sample_id = $value['sample_id'];
            break;
        }
        echo $sample_id . '<br>';

        $res = $sample->searchSampleByID($sample_id);
        if($res['code']==CODE_SUCCESS){
            echo 'search id success : <br>';
            dump($res['data']);
        }else{
            halt($res);
        }
        echo '<br>';


        $input = 'input';
        $output = 'output';

        $res = $sample->editSample($sample_id, $input, $output);
        if($res['code']==CODE_SUCCESS){
            echo 'edit success : <br>';
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $sample->searchSampleByID($sample_id);
        if($res['code']==CODE_SUCCESS){
            echo 'search id success : <br>';
            dump($res['data']);
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $sample->deleSample($sample_id);
        if($res['code']==CODE_SUCCESS){
            echo 'delete success';
        }else{
            halt($res);
        }
        echo '<br>';
    }

    public function UsergroupModel() {
//        $group = new GroupModel();
//        $res = $group->get_the_group(1);
//        halt($res);// for debug

        $user_group = new UsergroupModel();

        $res = $user_group->addRelation(1,1);
        if($res['code']==CODE_SUCCESS) {
            $user_group->addRelation(2, 1);
            $user_group->addRelation(1, 2);
            echo 'add relation success';
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $user_group->searchRelation(1,1);
        if($res['code']==CODE_SUCCESS) {
            echo 'searchRealtion success : ';
            dump($res['data']);
        }else{
            halt($res);
        }
        echo '<br>';


        /*
         *  TODO has problem (maybe in the GroupModel)
         */
        $res = $user_group->find_group(1);
        if($res['code']==CODE_SUCCESS) {
            echo 'find group success : ';
            dump($res['data']);
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $user_group->find_user(1);
        if($res['code']==CODE_SUCCESS) {
            echo 'find user success : ';
            dump($res['data']);
        }else{
            halt($res);
        }
        echo '<br>';
        /*
         * problem end
         */

        $res = $user_group->deleRelation(1,1);
        if($res['code']==CODE_SUCCESS) {
            $user_group->deleRelation(2,1);
            $user_group->deleRelation(1,2);
            echo 'delete Relation success';
        }else{
            halt($res);
        }

        echo 'test success';

//        $res1 = $user_group->addRelation(1,1);
//        $res2 = $user_group->addRelation(1,2);
//        dump($res1);
//        dump($res2);

    }

    public function groupModel() {
        $group = new GroupModel();

        $data = [
            'group_name'=>'test',
            'desc'=>'group describe',
            'group_creator'=>1
        ];

        $res = $group->newGroup($data);
        if($res) {
            echo 'new group success';
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $group->get_all_group();
        dump($res);

        $group_id = $res['data'][0]['group_id'];
        echo 'group_id : ' . $group_id;
        echo '<br>';

        $res = $group->get_the_group($group_id);
        if($res) {
            echo 'get_the_group success : ';
            dump($res['data']);
        }else{
            halt($res['data']);
        }
        echo '<br>';

        $new_data = [
            'group_name'=>'testForEdit',
            'desc'=>'IKIJIBIKI',
            'group_creator'=>2
        ];

        $res = $group->editGroup($group_id,$new_data);
        if($res){
            echo 'edit Group success';
        }else{
            halt($res);
        }
        $res = $group->get_the_group($group_id);
        dump($res['data']);
        echo '<br>';

        $res = $group->deleGroup($group_id);
        if($res){
            echo 'delete Success';
        }else{
            halt($res);
        }

    }

    public function privilegeModel() {
        $privilege = new PrivilegeModel();

        $res = $privilege->addPrivilege(1,'p1');
        if($res['code']==CODE_SUCCESS) {
            $privilege->addPrivilege(1,'g1');
            $privilege->addPrivilege(1,'p1');
            $privilege->addPrivilege(1,'admin');
            echo 'add privilege success';
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $privilege->searchOnesAllPrivilege(1);
        if($res['code']==CODE_SUCCESS) {
            echo 'search ones all privilege success : ';
            dump($res['data']);
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $privilege->searchPrivilege(1,'admin');
        if($res['code']==CODE_SUCCESS) {
            echo 'search privilege success : ';
            dump($res);
        }else{
            halt($res);
        }
        echo '<br>';

        $res = $privilege->delePrivilege(1,'admin');
        if($res['code']==CODE_SUCCESS) {
            $privilege->delePrivilege(1,'p1');
            $privilege->delePrivilege(1,'g1');
            echo 'delete privilege success';
        }else{
            halt($res);
        }
        echo '<br>';
        echo 'test success';
    }

    public function userController() {

    }

    public function loginController() {
        return view('login');
    }

    public function groupController() {

    }

    public function problemController() {

    }

}