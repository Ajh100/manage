<?php
namespace Home\Controller;
use Home\Controller\AdminController;

class IndexController extends AdminController{
    
    public function index(){
        $info = session('manage_auth');
        $gid = M('ManagerAuthGroupAccess')->where('uid ='.$info['uid'])->find();
        $group = M('ManagerAuthGroup')->field('title')->find($gid['group_id']);
        $this->assign(array(
            'info' => $info,
            'group'=> $group
        ));
        
        $this->display();
    }
    
    
    public function center(){
        $gd = '不支持';
        if (function_exists('gd_info')){
            $gd = gd_info();
            $gd = $gd['GD Version'];
        }

        $hostport = $_SERVER['SERVER_NAME']."($_SERVER[SERVER_ADDR]:$_SERVER[SERVER_PORT])";
        $mysql = function_exists('mysql_close') ? mysql_get_client_info(): '不支持';
        $info = array(
            'user' => session('manage_auth'),
            'now_login_ip' => get_client_ip(),
            'system' => PHP_OS,
            'hostport' => $hostport,
            'server' => $_SERVER['SERVER_SOFTWARE'],
            'php_env' => php_sapi_name(),
            'app_dir' => getcwd(),
            'mysql' => $mysql,
            'gd' => $gd,
            'upload_size' => ini_get('upload_max_filesize'),
            'exec_time' => ini_get('max_execution_time') . '秒',
            'disk_free' => round((@disk_free_space(".")/(1024 * 1024)),2).'M',
            'server_time' => date("Y-n-j H:i:s"),
            'beijing_time' => gmdate("Y-n-j H:i:s", time() + 8 * 3600),
            'reg_gbl' => get_cfg_var("register_globals") == '1'? 'ON' : 'OFF',
            'quotes_gpc' => (1 === get_magic_quotes_gpc()) ? 'YES' : 'NO',
            'fopen' => ini_get('allow_url_fopen') ? '支持' : '不支持'
        );
        
       
        
        $this->assign(array(
            'info'          => $info
        ));
        $this->display();
    }
    
}