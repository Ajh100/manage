<?php
namespace Home\Controller;
use Think\Controller;

class AdminController extends Controller{
 
    public function _initialize(){
        header("Content-Type: text/html; charset=utf-8");
        if(defined('UID')) return ;
            define('UID',is_manage_login());
        if( !UID ){
            $this->redirect('public/login');
        }
        //权限验证
        $name = CONTROLLER_NAME;
        if(!authcheck($name,UID)){
              $this->error('没有权限', U('public/logout'));
        }
    }
    
    public function delall(){
        $ids = I('post.id',0);
        if($ids){
            $map['id'] = array('in', implode(',', $ids));
            $result = M(CONTROLLER_NAME)->where($map)->delete();
            if($result){
                $this->success('删除成功',__CONTROLLER__.'/index');
            }else{
                $this->error('删除失败', __CONTROLLER__.'/index');
            }
        }
    }
}
