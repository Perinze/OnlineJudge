<?php
/**
 * Created by PhpStorm.
 * User: DarkKris
 * Date: 2018/5/4
 * Time: 上午8:45
 */
namespace app\index\Controller;

use think\Container;
use think\Controller;
use think\Exception;
use think\exception\HttpResponseException;
use think\Response;

class Base extends Controller{
    /**
     * view文件夹外调用：生成token（之后可能考虑关闭此方法）
     * @return string
     * @throws \Exception
     */
    public static function tokenGenerate()
    {
        $hash = bin2hex(random_bytes(16));
        cache($hash,md5(time()));
        return $hash;
    }

    /**
     * 验证token有效性
     * @param $token
     * @return bool
     */
    protected function checkToken($token)
    {
        if(strlen($token)==32)
        {
            $data = app('cache')->pull($token);
            if($data)return true;
        }
        return false;
    }

    /**
     * 检查用户身份级别
     * @param $userId
     * @return array|null|\PDOStatement|string|\think\Model
     */
    protected function checkUserType($userId)
    {
        try {
            $result = Db('user')->where('userId', $userId)->field('userType')->find();//TODO check
            return $result;
        }catch (Exception $e) {
            return -1;
        }
    }

    /**
     * 检查邀请码有效性
     * @param $rcode
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function checkRcode($rcode)
    {
        if(strlen($rcode)==16)
        {
            $rcode = Db('rcode')->where('code',$rcode);
            $data = $rcode->find();
            if($data['isUsed']==false)
            {
                $rcode->setField('isUsed',true);
                return true;
            }
        }
        return false;
    }

    /**
     * 重写success
     * @access protected
     * @param  mixed     $msg 提示信息
     * @param  string    $url 跳转的URL地址
     * @param  mixed     $data 返回的数据
     * @param  integer   $wait 跳转等待时间
     * @param  array     $header 发送的Header信息
     * @return void
     */
    protected function success($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : Container::get('url')->build($url);
        }

        $result = [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        // 把跳转模板的渲染下沉，这样在 response_send 行为里通过getData()获得的数据是一致性的格式
        if ('html' == strtolower($type)) {
            $type = 'jump';
        }

        $response = Response::create($result, $type)->header($header)->options(['jump_template' => Container::get('config')->get('dispatch_success_tmpl')]);

        throw new HttpResponseException($response);
    }

    /**
     * 重写error
     * @access protected
     * @param  mixed     $msg 提示信息
     * @param  string    $url 跳转的URL地址
     * @param  mixed     $data 返回的数据
     * @param  integer   $wait 跳转等待时间
     * @param  array     $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = Container::get('request')->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : Container::get('url')->build($url);
        }

        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ('html' == strtolower($type)) {
            $type = 'jump';
        }

        $response = Response::create($result, $type)->header($header)->options(['jump_template' => Container::get('config')->get('dispatch_error_tmpl')]);

        throw new HttpResponseException($response);
    }
}