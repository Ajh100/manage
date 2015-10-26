<?php

/*
单页分类
 */
namespace Home\Controller;
use Think\Controller;

class ArticleClassController extends AdminController{

    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }         
        }
        
        $list = M('ArticleClass')->order('pid asc,sort desc,id asc')->select();
        $list = getTree($list);
        
        $this->assign(array(
            'list' => $list
        ));
        $this->display(); 
    }
    
    
    public function add(){
        if(IS_POST){
           $model = D('ArticleClass');
           if($model->create()){
               $result = $model->add();
               if($result){
                   $this->success('添加成功', U('index'));
               }else{
                   $this->error('添加失败'.$model->getDbError() , __SELF__);
               }
           }else{
               $this->error('添加失败'.$model->getError() , __SELF__);
           }
        }else{
           $list = M('ArticleClass')->order('pid asc,sort desc,id asc')->select();
           $list = getTree($list);
           $this->assign(array(
               'list' => $list
           ));
           $this->display();
        }
    }
    
    
    public function edit($id){
        $model = D('ArticleClass');
        if(IS_POST){
            if($model->create()){
                $result = $model->save();
                if($result !== false){
                    $this->success('跟新成功', U('index'));
                }else{
                    $this->error('跟新失败'.$model->getDbError() , __SELF__);
                }
            }else{
                $this->error('跟新失败'.$model->getError() , __SELF__);
            }            
        }else{
            $id = I('get.id', 0, 'intval');
            $data = $model->find($id);
            $list = M('ArticleClass')->order('pid asc,sort desc,id asc')->select();
            $list = getTree($list);
            
            $this->assign(array(
                'data' => $data,
                'list' => $list
            ));
            $this->display();
        }
    }
    
}
