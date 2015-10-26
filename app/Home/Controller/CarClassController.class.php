<?php
/*
车型管理
 */
namespace Home\Controller;
use Think\Controller;
class CarClassController extends AdminController{

    public function index(){
            $map = array();
            $parameter = array();
            if(!empty($_REQUEST['brand'])){
                $map['brandtitle'] = array('like', '%'. $_REQUEST['brand'] .'%');
                $parameter['brand'] = $_REQUEST['brand'];
            }
            if(!empty($_REQUEST['series'])){
                $map['seriestitle'] = array('like', '%'. $_REQUEST['series'] .'%');
                $parameter['series'] = $_REQUEST['series'];
            }
            if(!empty($_REQUEST['keywords'])){
                $map['title'] = array('like', '%'. $_REQUEST['keywords'] .'%');
                $parameter['title'] = $_REQUEST['keywords'];
            }
        
        $model = D('CarClassView');
        
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        
        $page->parameter = array_merge($parameter,$page->parameter);
        
        $show  = $page->show();
        $list = $model->where($map)->order('sort desc')->limit($page->firstRow.','.$page->listRows)->select();

        cookie('_currentUrl_', __SELF__);
        $this->assign(array(
            'list' => $list,
            'page' => $show
        ));
        
        $this->display(); 
    }

    public function _getinfo(){

        
        $this->assign(array(
            'carbrand' => $carbrand,
            'carseries' => $carseries,
            'caryear' => $caryear,
            'carlevel' => $carlevel,
            'carstructure' => $carstructure,
            'caresid' => $caresid
        ));
    }


    public function add(){
        if(IS_POST){
           $model = D('CarClass');
           if($model->create()){
               $result = $model->add();
               if($result){
                   $this->success('添加成功', cookie('_currentUrl_'));
               }else{
                   $this->error('添加失败'.$model->getDbError() , cookie('_currentUrl_'));
               }
           }else{
               $this->error('添加失败'.$model->getError() , cookie('_currentUrl_'));
           }
        }else{
            
           //$map = array('status' => 0);
           $carbrand = M('CarBrand')->where($map)->order('letter asc, sort desc')->select();
           $carseries = M('CarSeries')->where($map)->select();
           $caryear = M('CarYear')->where($map)->select();
           $carlevel = M('CarLevel')->where($map)->select();
           $carstructure = M('CarStructure')->where($map)->select();
           $caresid = M('CarEsid')->where($map)->select();
           
           $this->assign(array(
                'carbrand' => $carbrand,
                'carseries' => $carseries,
                'caryear' => $caryear,
                'carlevel' => $carlevel,
                'carstructure' => $carstructure,
                'caresid' => $caresid
           ));
           $this->display();
        }
    }
    
    
    public function edit($id){
        $model = D('CarClass');
        if(IS_POST){
            if($model->create()){
                $result = $model->save();
                if($result !== false){
                    $this->success('跟新成功', cookie('_currentUrl_'));
                }else{
                    $this->error('跟新失败'.$model->getDbError() , cookie('_currentUrl_'));
                }
            }else{
                $this->error('跟新失败'.$model->getError() , U('index'));
            }            
        }else{
            $id = I('get.id', 0, 'intval');
            $data = $model->find($id);
            
           $carbrand = M('CarBrand')->where('is_lock = 0')->order('letter asc, sort desc')->select();
           $subbrand = M('CarSubBrand')->where('bid = '.$data['brand_id'])->select();
           $carseries = M('CarSeries')->where($map)->select();
           $caryear = M('CarYear')->where($map)->select();
           $carlevel = M('CarLevel')->where($map)->select();
           $carstructure = M('CarStructure')->where($map)->select();
           $caresid = M('CarEsid')->where($map)->select();
            
            $this->assign(array(
                'carbrand' => $carbrand,
                'subbrand' => $subbrand,
                'carseries' => $carseries,
                'caryear' => $caryear,
                'carlevel' => $carlevel,
                'carstructure' => $carstructure,
                'caresid' => $caresid,
                'data'=> $data,
            ));
            $this->display();
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
    
    public function ajax_series(){
        $map = array(
            'brand_id'=>$_GET['brand_id'],
            'sub_bid'=>$_GET['sub_bid'],
        );
        $list = M('CarSeries')->where($map)->select();
        if($list){
            $this->ajaxReturn($list);
        }else{
            $this->ajaxReturn(array('msg'=>1));
        }
    }
}
