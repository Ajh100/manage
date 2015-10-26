<?php 
namespace Home\Controller;
use Think\Controller;
class MemberAuthController extends AdminController{

        public function accessList(){
            if(IS_POST){
                $map = array();
                if(!empty($_POST['keywords'])){
                    $map['title'] = array('like', '%'. $_POST['keywords'] .'%');
                }         
            }

            $model = D('MemberRuleView');
            $count = $model->where($map)->count();
            $page  = new \Think\Page($count,5);
            $show  = $page->show();
            $list = $model->where($map)->limit($page->firstRow.','.$page->listRows)->select();
           
            $this->assign(array(
                'list' => $list,
                'page' => $show
            ));
            $this->display(); 
        }

    //添加权限
    public function accessEdit(){
        if(IS_POST){
            $model = M("MemberAuthRule");
            $data['id']=I('post.id');
            $data['name']=I('name');
            $data['title']=I('title');
            //过滤方法必须为空,否则验证时会出错
            $data['condition']=I('post.condition','','');
            $data['status']=I('status');
            $data['mid']=I('modules');
            if($model->save($data) !== false){
                    $this->success('编辑成功', U('UserAuth/accessList'));
            }else{
                    $this->error('编辑失败');
            }                   
        }else{
            $auth_rule = M("MemberAuthRule");
            $id = I('get.id');
            $data = $auth_rule->where('id = '.$id)->find();
            
            $modules = M('UserModules');
            $list = $modules->select();
            $this->assign(array(
                'list' => $list,
                'data' => $data,
                'modules' => $modules
            ));
            $this->display();
        }
    }
	//读取模块信息
    public function accessAdd(){
        if(IS_POST){
            $model = M("MemberAuthRule");
            $data['name'] = I('name');
            $data['title'] = I('title');
            //过滤方法必须为空,否则验证时会出错
            $data['condition'] = I('post.condition','','');
            $data['status'] = I('status');
            $data['mid'] = I('modules');
            if($model->add($data)){
                    $this->success('添加成功', U('accessList'));
            }else{
                    $this->error('添加失败');
            }                   
        }else{
            $modules = M('MemberModules');
            $data = $modules->select();
            $this->assign('modules',$data);
            $this->display();
        }
    }

    //角色管理页面
    public function groupList(){
    	$model = M('member_auth_group');
        $count = $model->count();
        $page = new \Think\Page($count,5);
        $show = $page->show();
        $data = $model->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
        $this->assign('page',$show);
        $this->assign('list',$data);
        $this->display();
    }

    //添加角色
    public function groupAdd(){
        if(IS_POST){
            $model = D("MemberAuthGroup");
            if($model->create()){
                if($model->add()){
                        $this->success('添加成功', U('groupList'));
                }else{
                        $this->error('添加失败');
                }           
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->display();
        }
    }
    
    //修改角色
    public function groupEdit(){
    	$model = D("MemberAuthGroup");
        if(IS_POST){
            if($model->create()){
                if($model->save() !== false){
                        $this->success('修改成功', U('groupList'));
                }else{
                        $this->error('修改失败');
                }           
            }else{
                $this->error('修改失败');
            }
        }else{
            $data = $model->find(I('get.id'));
            $this->assign('data', $data);
            $this->display();
        }
    }
    
    //删除角色
    public function groupDelete(){
        $ids = I('post.id',0);
        if($ids){
            $map['id'] = array('in', implode(',', $ids));
            $result = M('MemberAuthGroup')->where($map)->delete();
            if($result){
                $this->success('删除成功', U('groupList'));
            }else{
                $this->error('删除失败', U('groupList'));
            }
        }
    }

    //角色授权页面
    public function accessSelect(){
    	//角色id
    	$group['id']=$where['id']=I('id');
    	//角色名称
    	$group['name']= iconv("gb2312","UTF-8",$_GET['name']);;
    	$model = M('MemberAuthGroup');
        
        
    	//获取所有规则id
    	$ruleID = $model->field('rules')->where($where)->find();

    	$rule = D("MemberRuleView");
    	$mid = $rule->field('mid,moduleName')->group('mid')->select();
    	foreach ($mid as $v) {
    		$map['mid']=array('in',$v['mid']);
    		//$map['status']='1';    		
    		$result[$v['moduleName']]=$rule->where($map)->select();
    	}
        
        $this->assign(array(
            'group' => $group,
            'result' => $result,
            'ruleID' => $ruleID,
        ));
    	$this->display();
    }

    //更新角色授权
    public function accessSelectHandle(){
    	$arr = I('post.rule');
    	$where['id'] = I("post.groupID");
    	$data['rules'] = implode(',',$arr);
    	$model = M('MemberAuthGroup');
    	//更新,返回影响行数
    	$num = $model->where($where)->save($data);
    	if($num){
    		$this->success('权限更新成功!');
    	}else{
    		$this->error('权限更新失败!');
    	}
    }


    //删除权限
    public function accessDelete(){
       $map['id'] = array('in', implode( ',', I('post.id')));
       $model = M('MemberAuthRule');
       $result = $model->where($map)->delete();
       if($result){
            $this->success('权限删除成功!');
       }else{
            $this->error("权限删除失败!");
       }
    }

}

 ?>