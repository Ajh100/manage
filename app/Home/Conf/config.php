<?php
return array(

    //权限验证设置
    'AUTH_CONFIG'=>array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'tc_manager_auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'tc_manager_auth_group_access', //用户组明细表
        'AUTH_RULE' => 'tc_manager_auth_rule', //权限规则表
        'AUTH_USER' => 'tc_manager'//用户信息表
    ),
    //超级管理员id,拥有全部权限,只要用户uid在这个角色组里的,就跳出认证.可以设置多个值,如array('1','2','3')
    'ADMINISTRATOR'=>array('1'),
    

    /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'taoche8_admin', //session前缀

    /* 后台错误页面模板 */
   // 'TMPL_ACTION_ERROR'     =>  MODULE_PATH.'View/Public/error.html', // 默认错误跳转对应的模板文件
   // 'TMPL_ACTION_SUCCESS'   =>  MODULE_PATH.'View/Public/success.html', // 默认成功跳转对应的模板文件
   // 'TMPL_EXCEPTION_FILE'   =>  MODULE_PATH.'View/Public/exception.html',// 异常页面的模板文件
    
);