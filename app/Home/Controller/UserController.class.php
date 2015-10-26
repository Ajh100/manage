<?php

/*
友情链接
 */
namespace Home\Controller;
use Think\Controller;

class UserController extends AdminController{
    
    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['txtKeywords'])){
                $map['realname'] = array('like', '%'. $_POST['txtKeywords'] .'%');
            }    
            if(!empty($_POST['telphone'])){
                $map['moblie'] = array('like', '%'. $_POST['telphone'] .'%');
            }
        }
        
        $model = M('User');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        $show  = $page->show();
        $list = $model->where($map)->order('uid desc')->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign(array(
            'list' => $list,
            'page' => $show
        ));
        $this->display(); 
    }
    
    
    public function add(){
        if(IS_POST){
           $model = M('User');
           if(empty($_POST['realname'])){
                $this->error('姓名不能为空');
           }
           if(empty($_POST['moblie'])){
                $this->error('手机不能为空');
           }
           if(empty($_POST['password'])){
                $this->error('密码不能为空');
           }
           $user = $model->where(array('moblie'=>I('post.moblie')))->select();
           if($user){
              $this->error('添加失败手机号已经被注册');
              exit();
           }
           $result = $model->add(array(
                'nickname' => I('post.realname'),
                'moblie' =>  I('post.moblie'),
                'password' => md5(I('post.password')),
                'reg_time' => time(),
                'status' => I('post.status')
           ));
           if($result){
               $this->success('添加成功', U('index'));
           }else{
               $this->error('添加失败'.$model->getDbError() , U('index'));
           }
        }else{
           $this->display();
        }
    }


    public function edit(){

        $model = M('User');
        if(IS_POST){
           $userData = array();
            if(empty($_POST['uid'])){
                $this->error('数据错误');
            }
            if(empty($_POST['realname'])){
                $this->error('姓名不能为空');
            }
            if(empty($_POST['moblie'])){
                $this->error('手机不能为空');
            }
            if(!empty($_POST['password'])){
                $userData['password'] = md5(I('post.password'));
            }
           $user = $model->where(array('moblie'=>I('post.moblie'), 'uid' => array('neq',$_POST['uid'])))->select();
           if($user){
              $this->error('跟新失败手机号已经被注册');
              exit();
           }
            $userData['nickname'] = I('post.realname');
            $userData['moblie']  = I('post.moblie');
            $userData['status']  = I('post.status');
            $result = $model->where(array('uid'=>I('post.uid')))->save($userData);
            if($result !== false){
                $this->success('跟新成功', U('index'));
            }else{
                $this->error('跟新失败'.$model->getDbError() , U('index'));
            }        
        }else{
            $id = I('get.id', 0, 'intval');
            $data = $model->where('uid = '.$id)->find();
            $this->assign(array(
                'userData' => $data,
            ));
            $this->display();
        }
    }

    public function delete($id){

        $result = M('User')->where('uid = '. $id)->delete();
        if($result){
            $this->success('删除成功', U('index'));
        }else{
            $this->error('删除失败'.$model->getDbError() , U('index'));
        } 
    }
    
}
