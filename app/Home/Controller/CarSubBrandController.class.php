<?php
/*
子分类
 */
namespace Home\Controller;
use Think\Controller;
class CarSubBrandController extends AdminController{

    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }         
        }
        
        $model = D('CarSubBrandView');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        $show  = $page->show();
        $list = $model->where($map)->order('bid,sort desc')->limit($page->firstRow.','.$page->listRows)->select();
        
        cookie('_currentUrl_',__SELF__);
        $this->assign(array(
            'list' => $list,
            'page' => $show,
            'count'=> $count
        ));
        $this->display();
    }
    
    public function add() {
        $model = D('CarSubBrand');
        if(IS_POST){
            if($model->create()){
                $result = $model->add();
                if($result){
                    $this->success('添加成功', U('index'));
                }else{
                    $this->error('添加失败'.$model->getDbFields(), U('index'));
                }
            }else{
                $this->error('添加失败'.$model->getError(), U('index'));
            }
        }else{
            $brand = M('CarBrand')->where(array('status' => 0))->order('letter asc, sort desc')->select();
            $this->assign(array(
                'brand' => $brand
            ));
            $this->display();
        }
    }
    
    public function edit() {
        $model = D('CarSubBrand');
        if(IS_POST){
            if($model->create()){
                $result = $model->save();
                if($result !==false){
                    $this->success('跟新成功', cookie('_currentUrl_'));
                }else{
                    $this->error('跟新失败'.$model->getDbError() , cookie('_currentUrl_'));
                }
            }else{
                $this->error('跟新失败'.$model->getError() , cookie('_currentUrl_'));
            }
        }else{
            $id = I('get.id', 0, 'intval');
            $data = $model->find($id);
            $brand = M('CarBrand')->where(array('status' => 0))->order('id desc')->select();
            $this->assign(array(
                'data' => $data,
                'brand'=> $brand
            ));
            $this->display();
        }    
    }
 
    
}
