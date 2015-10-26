<?php 
namespace Home\Controller;
use Think\Controller;
class MemberController extends AdminController{
    
    //会员列表
    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }
            if(!empty($_POST['store'])){
                $map['store_id'] = I('post.store');
            }
        }
        
        $model = D('MemberView');
        $count=$model->count();
        $page=new \Think\Page($count,20);
        $show=$page->show();
        $list = $model->where($map)->limit($page->firstRow.','.$page->listRows)->order('store_id desc')->select();

        //店铺列表
        $store = M('Store')->field('id,title')->order('')->select();
        $this->assign(array(
            'list'  => $list,
            'store' => $store 
        ));
        $this->assign('page',$show);
        $this->display();
    }

    public function add(){
        if(IS_POST){
           $model = D('Member');
           if($model->create()){
               $result = $model->add();
               if($result){
                   $this->success('添加成功'.$result, U('index'));
               }else{
                   $this->error('添加失败'.$model->getDbError() , U('index'));
               }
           }else{
               $this->error('添加失败'.$model->getError() , U('index'));
           }
        }else{
           $store = M('Store')->order('id,area,city')->select();
           $this->assign(array(
               'store' => $store
           ));
           $this->display();
        }
    }
    
    
    public function edit(){
        $model = D('Member');
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
            $id = I('get.uid', 0, 'intval');
            $data = $model->where('uid ='.$id)->find();
            $store = M('Store')->order('area,city,id')->select();
            
            $this->assign(array(
                'store' => $store,
                'data' => $data
            ));
            $this->display();
        }
    }
}
 ?>