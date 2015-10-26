<?php
/*
车系管理
 */
namespace Home\Controller;
use Think\Controller;
class CarSeriesController extends AdminController{
    
    public function index(){
        $map = array();
        $parameter = array();
        if(!empty($_REQUEST['keywords'])){
            $map['title'] = array('like', '%'. $_REQUEST['keywords'] .'%');
            $parameter['title'] = $_REQUEST['keywords'];
        }
        if(!empty($_REQUEST['brandtitle'])){
            $map['brandtitle'] = array('like', '%'. $_REQUEST['brandtitle'] .'%');
            $parameter['brandtitle'] = $_REQUEST['brandtitle'];
        }
        
        $model = D('CarSeriesView');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        $page->parameter = array_merge($parameter,$page->parameter);
        $show  = $page->show();
        $list = $model->where($map)->order('brand_id, sort desc')->limit($page->firstRow.','.$page->listRows)->select();
        cookie('_currentUrl_', __SELF__);
        $this->assign(array(
            'list' => $list,
            'page' => $show,
            'count'=> $count
        ));
        $this->display();
    }
    
    public function add() {
        $model = D('CarSeries');
        if(IS_POST){
            if($model->create()){
                $result = $model->add();
                if($result){
                    $this->success('添加成功', U('index'));
                }else{
                    $this->error('添加失败'.$model->getDbFields());
                }
            }else{
                $this->error('添加失败'.$model->getError());
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
        $model = D('CarSeries');
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
            $brand = M('CarBrand')->where(array('status' => 0))->order('id desc')->select();
	    $subbrand = M('CarSubBrand')->where(array('status' => 0, 'bid' => $data['brand_id']))->order('id desc')->select();
            
            $this->assign(array(
                'data' => $data,
                'brand'=> $brand,
		'subbrand' => $subbrand
            ));
            $this->display();
        }    
    }
    
    public function ajaxselect(){
        $list = M('CarSubSeries')->where(array('bid'=>$_GET['bid']))->select();
        if($list){
            $this->ajaxReturn($list);
        }else{
            $this->ajaxReturn(array('msg'=>1));
        }
    }
	
    public function ajax_subbrand(){
        $list = M('CarSubBrand')->where(array('bid'=>$_GET['bid']))->select();
            
        if($list){
            $this->ajaxReturn($list);
        }else{
            $this->ajaxReturn(array('msg'=>1));
        }
    }
}
