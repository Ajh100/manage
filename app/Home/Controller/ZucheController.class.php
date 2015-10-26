<?php

/*
友情链接
 */
namespace Home\Controller;
use Think\Controller;

class ZucheController extends AdminController{
    
    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['txtKeywords'])){
                $map['phone'] = array('like', '%'. $_POST['txtKeywords'] .'%');
            }         
        }
        
        $model = M('Zuche');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,5);
        $show  = $page->show();
        $list = $model->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign(array(
            'list' => $list,
            'page' => $show
        ));
        $this->display(); 
    }
    
    
    public function edit($id){
        $model = M('Zuche');
        $id = I('get.id', 0, 'intval');
        $data = $model->where('id = '.$id)->save(array(
            'status' => 1
        ));

        if($data){
            $this->success('处理成功');
        }else{
            $this->error('处理成功');
        }
    }
    
}
