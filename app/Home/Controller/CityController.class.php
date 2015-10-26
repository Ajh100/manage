<?php
/*
城市管理
 */
namespace Home\Controller;
use Think\Controller;
class CityController extends AdminController{
    
    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }
            if(!empty($_POST['area'])){
                $map['area_id'] = I('post.area');
            }
        }
        
        $model = D('CityView');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        $show  = $page->show();
        $list = $model->where($map)->order('sort desc')->limit($page->firstRow.','.$page->listRows)->select();

        $area = M('Area')->field('id,title')->order('pinyin asc,sort desc')->select();
        $this->assign(array(
            'list' => $list,
            'page' => $show,
            'area' => $area
        ));
        $this->display(); 
    }
    
    public function add(){
        if(IS_POST){
           $model = D('City');
           if($model->create()){
               $result = $model->add();
               if($result){
                   $this->success('添加成功', U('index'));
               }else{
                   $this->error('添加失败'.$model->getDbError() , U('index'));
               }
           }else{
               $this->error('添加失败'.$model->getError() , U('index'));
           }
        }else{
           $area = M('Area')->where('status =0')->order('pinyin asc, sort desc')->select();
           $this->assign('area', $area);
           $this->display();
        }
    }
    
    public function edit($id){
        $model = D('City');
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
            $area = M('Area')->where('status =0')->order('pinyin asc, sort desc')->select();
            $this->assign('area', $area);
            $this->assign('data', $data);
            $this->display();
        }
    }
}
