<?php

namespace Home\Controller;
use Think\Controller;

/**
销售员
 */
class SalemanController extends AdminController{
    
    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }
            if(!empty($_POST['area'])){
                $map['area'] = I('post.area');
            }
            if(!empty($_POST['city'])){
                $map['city'] = I('post.city');
            }
        }

        $model = D('SalemanView');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,5);
        $show  = $page->show();
        $list = $model->where($map)->order('store_id desc,zhiwei desc')->limit($page->firstRow.','.$page->listRows)->select();
        
        $area = M('Area')->field('id,title')->order('pinyin asc')->select();
        $city = M('City')->field('id,title')->order('pinyin asc')->select();
        
        $this->assign(array(
            'list' => $list,
            'page' => $show,
            'area' => $area,
            'city' => $city
        ));
        $this->display(); 
    }
    
    public function add(){
        if(IS_POST){
           $model = D('Saleman');
           if($model->create()){
               $result = $model->add();
               if($result){
                   $this->success('添加成功', U('index'));
               }else{
                   $this->error('添加失败'.$model->getDbError());
               }
           }else{
               $this->error('添加失败'.$model->getError());
           }
        }else{
           $this->display();
        }
    }
    
    public function edit(){
        $model = D('Saleman');
        if(IS_POST){
            if($model->create()){
                $result = $model->save();
                if($result !== false){
                    $this->success('跟新成功', cookie('_currentUrl_'));
                }else{
                    $this->error('跟新失败'.$model->getDbError());
                }
            }else{
                $this->error('跟新失败'.$model->getError());
            }            
        }else{
            $id = I('get.id', 0, 'intval');
            $data = $model->find($id);
            $this->assign('data', $data);
            $this->display();
        }
    }
}
