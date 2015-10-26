<?php 
namespace Home\Controller;
use Home\Controller\AdminController;
class ManagerController extends AdminController{
    
    //会员列表
    public function index(){
            $model = D('GroupManagerView');
            //总记录数
            $count=$model->count();
            //每页显示多少条记录
            $page=new \Think\Page($count,15);
            $show=$page->show();
            $list = $model->field('password',true)->limit($page->firstRow.','.$page->listRows)->order('group_id')->select();
            $this->assign('list',$list);
            $this->assign('page',$show);
            $this->display();
    }

    //添加会员页面
    public function add(){

        if(IS_POST){

            $manager = D('Manager');
            $groupname=I("post.groupname");

            if($manager->create()){

                if($uid = $manager->add()){

                    $map = array('uid'=>$uid, 'group_id'=>$groupname);
                    $auth_group_access =M("ManagerAuthGroupAccess");

                    if($auth_group_access->add($map)){
                            $this->success('添加成功!', U('index'));
                    }else{
                            $this->error('添加失败');
                    }
                }else{
                    $this->error('添加失败'.$manager->getDbError());
                }

            }else{
                $this->error('添加失败'.$manager->getError());
            }
        }else{
            $auth_group = M('ManagerAuthGroup')->where('status = 1')->field('id,title')->select();
            $this->assign(array(
                'auth_group' => $auth_group,
            ));
            $this->display();
        }
    }

    public function edit(){
        if(IS_POST){
            $manager = D('Manager');
            $groupname=I("post.groupname");

            if($manager->create()){
                if($manager->save() === false){
                    $this->error('修改失败');
                }else{
                    $data['group_id'] = $groupname;
                    $result =M("ManagerAuthGroupAccess")->where('uid ='.I('post.uid'))->save($data);
                    if($result !== false){
                            $this->success('修改成功!', U('index'));
                    }else{
                            $this->error('修改失败');
                    }
                }
            }else{
                $this->error('修改失败'.$manager->getError());
            }               
        }else{
            $uid = I('get.uid');
            $manager = M('Manager')->where('uid = '.$uid)->find();
            $auth_group_access = M('ManagerAuthGroupAccess')->where('uid ='.$uid)->find();
            $auth_group = M('ManagerAuthGroup')->where('status = 1')->field('id,title')->select();
            $this->assign(array(
                'manager' => $manager,
                'auth_group_access' => $auth_group_access,
                'auth_group' => $auth_group,
            ));
            $this->display();
        }
    }
    //删除会员
    public function delete(){
        $ids = I('post.uid',0);
        if($ids){
            $map['uid'] = array('in', implode(',', $ids));
            $members = M('User');
            $members->startTrans();
            $res1 = $members->where($map)->delete();
            $res2 = M('ManagerAuthGroupAccess')->where($map)->delete();
            if($res1 && $res2){
                $members->commit();
                $this->success('删除成功', U('index'));
            }else{
                $members->rollback();
                $this->error('删除失败', U('index'));
            }
        }
    }
    
    public function repass(){
        $id = I('get.uid',0);
        $manager = D('Manager');
        if(IS_POST){
            if(empty($_POST['password'])){
                $this->error('密码不能为空');
            }
            if(empty($_POST['repassword'])){
                $this->error('确认密码不能为空');
            }
            if($_POST['password'] !== $_POST['repassword']){
                $this->error('确认密码不一致');
            }
            $data = array(
                'password' => think_manager_md5(I('post.password'), C('DATA_AUTH_KEY'))
            );
            $res = $manager->where('uid ='.I('post.uid',0))->save($data);
            if($res !== false){
                $this->success('密码修改成功'.I('post.password'), U('manager/index'));
            }else{
                $this->error('修改失败', U('manager/index'));
            }
        }else{
            $data = $manager->where('uid = '.$id)->find();
            $this->assign('data', $data);
            $this->display();
        }
    }
    
    //修改个人密码
    public function repassword(){
        $manager = D('Manager');
        $info = session('manage_auth');
        if(IS_POST){
            if(empty($_POST['password'])){
                $this->error('密码不能为空');
            }
            if(empty($_POST['repassword'])){
                $this->error('确认密码不能为空');
            }
            if($_POST['password'] !== $_POST['repassword']){
                $this->error('确认密码不一致');
            }
            $data = array(
                'password' => think_manager_md5(I('post.password'), C('DATA_AUTH_KEY'))
            );
            $res = $manager->where('uid ='.$info['uid'])->save($data);
            if($res !== false){
                $this->success('密码修改成功'.I('post.password'), U('index/center'));
            }else{
                $this->error('修改失败', U('manager/index'));
            }
        }else{
            $this->assign('data', $info);
            $this->display('repass');
        }
    }
}
 ?>