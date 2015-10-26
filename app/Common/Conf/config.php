<?php
return array(
    'MULTI_MODULE' => false,
    'DEFAULT_MODULE' => 'Home',
    
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'jh100',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'Kiihy*^&yihi6867',          // 密码
    'DB_PREFIX' => 'tc_', // 数据库表前缀 
    'DB_CHARSET'=> 'utf8', // 字符集
    
    'WEB_RES_URL' => 'http://res.jh100.com/',
	'WEB_PC_URL' => 'http://www.jh100.com/',
    
    
    'DATA_AUTH_KEY' => 'tke")*Bs6]2<Sg8Ca3Y>5dFq@,znLH4KI%?R=.~h',
    'USER_ADMINISTRATOR' => 1, //管理员用户ID
    
    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 1, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符
    
    'UPLOAD_FILE_SIZE' => 1000000, //最大上传文件
	
    'THINK_EMAIL' => array(
        'SMTP_HOST'   => 'smtp.163.com', //SMTP服务器
        'SMTP_PORT'   => '25', //SMTP服务器端口
        'SMTP_USER'   => 'jh100@qq.com', //SMTP服务器用户名
        'SMTP_PASS'   => 'nichaolastes2013', //SMTP服务器密码
        'FROM_EMAIL'  => 'jh100@qq.com', //发件人EMAIL
        'FROM_NAME'   => 'www.jh100.com', //发件人名称
        'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
        'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
     ),
);