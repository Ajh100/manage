<?php
namespace Home\Controller;
use Think\Controller;
/**
加盟留言
 */
class JoinController extends AdminController{
    
    public function index(){
        if(IS_POST){
            $map = array();
            if(!empty($_POST['keywords'])){
                $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
            }
            if(isset($_POST['property'])){
                switch ($_POST['property']) {
                    case 'is_red':
                         $map['is_red'] = 1;
                         break;
                    case 'is_hot':
                        $map['is_hot'] = 1;
                        break;
                    case 'is_lock':
                        $map['is_lock'] = 1;
                        break;
                    default:
                        break;
                }
            }
        }
        
        $model = M('Join');
        $count = $model->where($map)->count();
        $page  = new \Think\Page($count,15);
        $show  = $page->show();
        $list = $model->where($map)->order('addtime desc')->limit($page->firstRow.','.$page->listRows)->select();
        cookie('_currentUrl_',__SELF__);
        $this->assign(array(
            'list' => $list,
            'page' => $show
        ));
        $this->display(); 
    }
    
    
    public function add(){
        if(IS_POST){
           $model = D('Join');
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
           $this->assign('letter', range('A','Z'));
           $this->display();
        }
    }
    
    
    public function edit($id){
        $model = D('Join');
        if(IS_POST){
            if($model->create()){
                $result = $model->save();
                if($result !== false){
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
            $this->assign('letter', range('A','Z'));
            $this->assign('data', $data);
            $this->display();
        }
    }
}
