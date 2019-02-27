<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2019/2/26
 * Time: 下午8:24
 */
namespace app\oj\controller;

use app\oj\model\SampleModel;
use app\oj\model\UserModel;
use think\Controller;

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
}