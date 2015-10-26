<?php
namespace Home\Controller;
use Think\Controller;

class CarLevelController extends AdminController{
    
    public function index(){
        
        $map = array();
        if(!empty($_POST['keywords'])){
            $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
        }
        
        $model = M('CarLevel');
        $count = $model->where($map)->count();
        $list = $model->where($map)->order('sort desc')->select();
        $list = list_to_tree($list, $pk = 'id', $pid = 'pid');
        
        $this->assign(array(
            'list' => $list,
        ));
        $this->display();
        
    }

    public function tree($tree = null){
        $this->assign('tree', $tree);
        $this->display('tree');
    }    
    
    public function add(){
        $model = D('CarLevel');
        if(IS_POST){
            if($model->create()){
                $result = $model->add();
                if($result){
                    $this->success('添加成功', U('index'));
                }else{
                    $this->error('添加失败'.$model->getDbError(), U('index'));
                }
            }else{
                $this->error('添加失败'.$model->getError(), U('index'));
            }
        }else{
            $list = $model->where(array('pid' => 0))->select();
            $this->assign('list', $list);
            $this->display();
        }
    }
    
    public function edit($id){
        $model = D('CarLevel');
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
            $list = $model->where(array('pid' => 0))->select();
            $this->assign(array(
                'data' => $data,
                'list' => $list
            ));
            $this->display();
        } 
    }
      
}
