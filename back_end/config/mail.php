<?php



/**************邮件配置信息***********/

return [
    'charset' => 'utf-8',         // 邮件编码
    'smtp_debug' => 0,           // Debug模式。0: 关闭，1: 客户端消息，2: 客户端和服务器消息，3: 2和连接状态，4: 更详细
    'debug_output' => 'html',       // Debug输出类型。`echo`（默认）,`html`,或`error_log`
    'host' => 'smtp.163.com',       // SMTP服务器地址
    'port' => 465,             // 端口号。默认25
    'smtp_auth' => true,          // 启用SMTP认证
    'smtp_secure' => 'ssl',        // 启用安全协议。''（默认）,'ssl'或'tls'，留空不启用
    'username' => 'acmwut@163.com', // SMTP登录邮箱
    'password' => 'acmwut123',     // SMTP登录密码。qq邮箱使用客户端授权码，QQ邮箱用独立密码
    'from' => 'acmwut@163.com',     	// 发件人邮箱
    'from_name' => '武汉理工大学ACM协会',         		// 发件人名称
    'reply_to' => '',           		// 回复邮箱的地址。留空取发件人邮箱
    'reply_to_name' => '',         		// 回复邮箱人名称。留空取发件人名称
];


