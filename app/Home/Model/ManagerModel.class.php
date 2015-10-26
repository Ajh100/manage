<?php

/*
网站管理员
 */
namespace Home\Model;
use Think\Model;
class ManagerModel extends Model{

    protected $_validate = array(
        array('account','/^[a-z]\w{4,}$/i','帐号格式错误'),
        array('password','require','密码必须'),
        array('repassword','require','确认密码必须'),
        array('repassword','password','确认密码不一致',0,'confirm'),
        array('account','','帐号已经存在',0,'unique',3),
    );

    protected $_auto = array(
        array('password','pwdhash',3,'callback'), 
        array('create_time','time',1,'function'),
        array('update_time','time',2,'function'),
    );

    public function pwdhash() {
        if(isset($_POST['password'])) {
                return think_manager_md5($_POST['password'], C('DATA_AUTH_KEY'));
        }else{
                return false;
        }
    }
}
