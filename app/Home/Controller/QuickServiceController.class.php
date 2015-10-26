<?php
/*
帮卖管理
 */
namespace Home\Controller;
use Think\Controller;

class QuickServiceController extends AdminController{
    
    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }         
        }

        $model = M('QuickService');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        $show  = $page->show();
        $list = $model->where($map)->order('addtime desc')->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign(array(
            'list' => $list,
            'page' => $show
        ));
        $this->display();
    }
    
    public function read($id){
        $result = M('QuickService')->where('id ='.$id)->setField('status',1);
        if($result !== false){
            $this->success('已审核');
        }else{
            $this->error('审核失败');
        }
    }
}
