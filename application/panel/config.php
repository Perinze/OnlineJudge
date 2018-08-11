<?php
//配置文件
define("VALIDATE_PASS", true);
define("VALIDATE_ERROR", false);
define("CODE_SUCCESS", 0);
define("CODE_ERROR", -1);
define("SUPER_ADMIN", 2);
define("SUPER_ADMIN_NAME", "大狗官");
define("GENERAL_ADMIN", 1);
define("GENERAL_ADMIN_NAME", "狗官");
define("CIVILIAN", 0);
define("CIVILIAN_NAME", "庶民");

return [
    //模板参数替换
    'view_replace_str'       => array(
        '__API__'    => '/ziqiangweb_v3.0/public/index.php/api',
        '__PANEL__'  => '/ziqiangweb_v3.0/public/index.php/panel',
        '__CSS__'    => '/ziqiangweb_v3.0/public/static/css',
        '__FONT__'   => '/ziqiangweb_v3.0/public/static/fonts',
        '__JS__'     => '/ziqiangweb_v3.0/public/static/js',
        '__IMG__'    => '/ziqiangweb_v3.0/public/static/images',
        '__UE__'     => '/ziqiangweb_v3.0/public/static/ueditor',
        '__UM__'     => '/ziqiangweb_v3.0/public/static/umeditor',
        '__DT__'     => '/ziqiangweb_v3.0/public/static/datatable',
    ),
    "jwtkey" => "ea68r78wcq4e2qw9+2x4dqw4dzq2w4+4WE+24XR434TC8546Y.465564IB685.I47686I.1U6VRC1T6X3R.6ZW1165`11W561Z5612E1056231RX52361RX2056X31E2561E56211E0/5610E1562X",
    "salt"   => "wqec1q7w82xe8wq4xe8wq478wcq4e2qw9+2ex68wq4xe8wq624xe6qw4262EEWE5E45E4c564ece5a4e5CE56CECRR  R2a54 A E4ERS 06SR",
    "Redis" => [
        "host" => "127.0.0.1",
        "port" => "6379"
    ]
];