<?php

/*
店铺管理
 */
namespace Home\Controller;
use Think\Controller;
class StoreController extends AdminController{
    
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
		
        $model = D('StoreView');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        $show  = $page->show();
        $list = $model->where($map)->order('area_id desc,city_id desc')->limit($page->firstRow.','.$page->listRows)->select();
        
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
           $model = D('Store');
           if($model->create()){
               $result = $model->add();
               if($result){
                   //保存相册
                   $albumarr = I('post.hide_photo_name');
                   $model->where('id ='.$result)->data(array('imglist'=>json_encode($albumarr)))->save();
                   $this->success('添加成功', U('index'));
               }else{
                   $this->error('添加失败'.$model->getDbError() , U('index'));
               }
           }else{
               $this->error('添加失败'.$model->getError() , U('index'));
           }
        }else{
           $area = M('Area')->where('status = 0')->order('pinyin, sort desc')->select();
           $this->assign(array(
               'area' => $area,
           ));
           $this->display();
        }
    }
    
    
    public function edit(){
        $model = D('Store');
        if(IS_POST){
            if($model->create()){
                $result = $model->save();
                if($result !== false){
                    //保存相册
                    $albumarr = I('post.hide_photo_name');
                    $model->where('id ='.I('post.id'))->data(array(
                        'service' => implode(',', I('post.service')),
                        'imglist'=>json_encode($albumarr)
                    ))->save();
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
            $area = M('Area')->where('status = 0')->order('pinyin, sort desc')->select();
            $city = M('City')->where('area_id = '.$data['area'])->order('pinyin, sort desc')->select();
            //$service = M('Service')->order('sort desc')->select();
            
            $this->assign(array(
                'area' => $area,
                'city' => $city,
                //'service' => $service,
                'data' => $data,
                'imglist' => json_decode($data['imglist'], true)
            ));
            $this->display();
        }
    }
    
    public function ajax_select(){
        $list = M('City')->where(array('area_id'=>$_GET['area_id']))->select();
        if($list){
            $this->ajaxReturn($list);
        }else{
            $this->ajaxReturn(array('msg'=>1));
        }
    }
    
}
