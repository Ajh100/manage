<?php
namespace Home\Controller;
use Think\Controller;
/**
文章
 */
class NoticeController extends AdminController{
    
    public function index(){
        $map = array();
        if(IS_POST){
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }         
            if(!empty($_POST['classid'])){
                $map['classid'] = $_POST['classid'];
            }
        }
        
        $model = D('NoticeView');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        $show  = $page->show();
        $list = $model->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
      
        
        $listclass = M('NoticeClass')->order('sort desc,id asc')->select();
        
        $this->assign(array(
            'list' => $list,
            'page' => $show,
            'classlist' => $listclass,
            'map' => $map
        ));
        $this->display(); 
    }
    
    
    public function add(){
        if(IS_POST){
           $model = D('Notice');
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
           $list = M('NoticeClass')->order('sort desc,id asc')->select();
           $this->assign(array(
               'classlist' => $list
           ));
           $this->display();
        }
    }
    
    
    public function edit($id){
        $model = D('Notice');
        if(IS_POST){
            if($model->create()){
                $result = $model->save();
                if($result !== false){
                    $this->success('跟新成功', U('index'));
                }else{
                    $this->error('跟新失败'.$model->getDbError() , U('index'));
                }
            }else{
                $this->error('跟新失败'.$model->getError() , U('index'));
            }            
        }else{
            $id = I('get.id', 0, 'intval');
            $data = $model->find($id);
            
            $list = M('NoticeClass')->order('sort desc,id asc')->select();
            
            $this->assign(array(
                'data' => $data,
                'classlist' => $list
            ));
            $this->display();
        }
    }
}
