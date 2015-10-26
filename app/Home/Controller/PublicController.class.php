<?php
namespace Home\Controller;
use Think\Controller;

class PublicController extends Controller{

    public function ueditor(){
    	$data = new \Org\Util\Ueditor();
	echo $data->output();
    }  
     
    
    public function login(){
        if(is_manage_login()){
            $this->redirect(__APP__);
        }
        $this->display();
    }
    
    //验证码
    public function verify(){
        $verify=new \Think\Verify();
        $verify->fontSize = 50;
        $verify->length   = 4;
        $verify->entry();
    }

    //登录验证
    public function checklogin(){
        
        if(empty($_POST['txtusername'])){
                    echo json_encode(array(
                        'status' => 1,
                        'msg' => '账号错误'
                    ));
                    exit();
        }
        if(empty($_POST['txtuserpwd'])){
                    echo json_encode(array(
                        'status' => 1,
                        'msg' => '密码必须'
                    ));
                    exit();
        }
        if(empty($_POST['txtcode'])){
                    echo json_encode(array(
                        'status' => 1,
                        'msg' => '验证码必须'
                    ));
                    exit();
        }
        if(!check_verify($_POST['txtcode'])){
                    echo json_encode(array(
                        'status' => 1,
                        'msg' => '验证码错误'
                    ));
                    exit();
        }
   
        $map['account'] = I('post.txtusername');
        $result = D('Manager')->where($map)->find();
        
        $loginErrorTimes = cookie('login_error_times');
        if(is_array($result) and $result['status'] == 1){
            if($result['password'] != think_manager_md5(I('post.txtuserpwd'), C('DATA_AUTH_KEY'))){
                log_write(I('post.txtusername'),'管理登录','失败[密码错误]'.get_client_ip());
                $loginErrorTimes > 0 ? $loginErrorTimes++ : $loginErrorTimes = 1;
                cookie('login_error_times', $loginErrorTimes ,array('expire'=>180));
                echo json_encode(array(
                        'status' => 1,
                        'msg' => '密码错误'
                ));
                exit();
            }else{
                $auth_group_access = M('ManagerAuthGroupAccess')->where('uid = '.$result['uid'])->find();
                $auth = array(
                    'uid'             => $result['uid'],
                    'account'         => $result['account'],
                    'username'        => $result['nickname'],
                    'last_login_time' => $result['last_login_time'],
                    'last_login_ip'   => $result['last_login_ip'],
                );
                $result['uid'] == 1 ? session('user_group_id', 0) : session('user_group_id', $auth_group_access['group_id']);
                session('manage_auth', $auth);
                session('manage_auth_sign', data_auth_sign($auth));
                $data = array(
                    'uid' => $result['uid'],
                    'login_count' => $result['login_count'] + 1,
                    'last_login_time' => time(),
                    'last_login_ip' => get_client_ip()
                );
                $res = D('Manager')->save($data);
				
                log_write(I('post.txtusername'),'管理登录','成功'.get_client_ip());
                echo json_encode(array(
                        'status' => 2,
                        'msg' => '登陆成功'
                ));
                exit();
            }
        }else{
            log_write(I('post.txtusername'),'管理登录','失败[用户名错误]'.get_client_ip());
            $loginErrorTimes > 0 ? $loginErrorTimes++ : $loginErrorTimes = 1;
            cookie('login_error_times', $loginErrorTimes ,array('expire'=>180));
            echo json_encode(array(
                    'status' => 1,
                    'msg' => '用户名错误'
            ));
            exit();
        }

    }

    //退出
    public function logout(){
        session('manage_auth', null);
        session('manage_auth_sign', null);
        $this->success('退出成功!',U('index/index'));
    } 
 
}
