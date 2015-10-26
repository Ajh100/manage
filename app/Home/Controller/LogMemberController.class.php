<?php

/*
日志
 */
namespace Home\Controller;
use Think\Controller;

class LogMemberController extends AdminController{
    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['author'])){
                $map['author'] = array('like', '%'. $_POST['author'] .'%');
            }
            if(!empty($_POST['action'])){
                $map['action'] = array('like', '%'. $_POST['action'] .'%');
            }
            if(!empty($_POST['content'])){
                $map['content'] = array('like', '%'. $_POST['content'] .'%');
            }
        }
        
        $model = M('LogMember');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,25);
        $show  = $page->show();
        $list = $model->where($map)->order('datetime desc')->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign(array(
            'list' => $list,
            'page' => $show
        ));
        $this->display(); 
    }
    
    public function delall(){
        $ids = I('post.id',0);
        if($ids){
            $map['id'] = array('in', implode(',', $ids));
            $result = M('LogMember')->where($map)->delete();
            if($result){
                $this->success('删除成功', U('LogMember/Index'));
            }else{
                $this->error('删除失败', U('LogMember/Index'));
            }
        }
    }
}
