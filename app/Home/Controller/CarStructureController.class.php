<?php
/*
车身结构
 */
namespace Home\Controller;
use Think\Controller;
class CarStructureController extends AdminController{
    
    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }         
        }
        
        $model = M('CarStructure');
        $list = $model->where($map)->order('sort desc')->select();

        $this->assign(array(
            'list' => $list
        ));
        $this->display();
    }
    
    public function add(){
        $model = D('CarStructure');
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
            $this->display();
        }
    }
    
    public function edit() {
        $model = D('CarStructure');
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
            $this->assign('data', $data);
            $this->display();
        }       
    }
}
