<?php

namespace custom;
use PHPMailer\PHPMailer\PHPMailer;
/**
 * 邮件服务类
 */
class Mailer extends PHPMailer{
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('PRC');             			// 默认时区设置
        $this->CharSet = config('mail.charset');          		// 邮件编码设置
        $this->isSMTP();                      					// 启用SMTP服务
        $this->SMTPDebug = config('mail.smtp_debug');       	// Debug模式级别
        $this->Debugoutput = config('mail.debug_output');     // Debug输出类型
        $this->Host = config('mail.host');             			// SMTP服务器地址
        $this->Port = config('mail.port');             			// 端口号
        $this->SMTPAuth = config('mail.smtp_auth');        		// SMTP登录认证
        $this->SMTPSecure = config('mail.smtp_secure');      		// SMTP安全协议
        $this->Username = config('mail.username');         			// SMTP登录邮箱
        $this->Password = config('mail.password');         			// SMTP登录密码
        $this->setFrom(config('mail.from'), config('mail.from_name'));      // 发件人邮箱和名称
        $this->addReplyTo(config('mail.reply_to'), config('mail.reply_to_name')); // 回复邮箱和名称
    }
    /**
     * 发送邮件
     * @param [type] $toMail   收件人地址
     * @param [type] $toName   收件人名称
     * @param [type] $subject   邮件主题
     * @param [type] $content   邮件内容，支持html
     * @param [type] $attachment 附件列表。文件路径或路径数组
     * @return [type]       成功返回true，失败返回错误消息
     */

    public function sendMail($toMail, $toName, $subject, $content, $attachment = null){
        $this->addAddress($toMail, $toName);
        $this->Subject = $subject;
        $this->msgHTML($content);

        if($attachment) { // 添加附件
            if(is_string($attachment)){
                is_file($attachment) && $this->AddAttachment($attachment);
            }else if(is_array($attachment)){
                foreach ($attachment as $file) {
                    is_file($file) && $this->AddAttachment($file);
                }
            }
        }
        if(!$this->send()){ // 发送
            return $this->ErrorInfo;
        }else{
            return true;
        }
    }
}

