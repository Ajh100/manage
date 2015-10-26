<?php
/*
环保标准
 */
namespace Home\Controller;
use Think\Controller;
class CarEsidController extends AdminController{

    public function index(){
        
        $map = array();
        if(!empty($_POST['keywords'])){
            $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
        }
        
        $model = M('CarEsid');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        $show  = $page->show();
        $list = $model->where($map)->order('sort desc')->limit($page->firstRow.','.$page->listRows)->select();
        
        $this->assign(array(
            'list' => $list,
            'page' => $show
        ));
        $this->display();
        
    }

    
    public function add(){
        $model = D('CarEsid');
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
            $this->assign('list', $list);
            $this->display();
        }
    }
    
    public function edit($id){
        $model = D('CarEsid');
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
            $this->assign(array(
                'data' => $data
            ));
            $this->display();
        } 
    } 
    
}
