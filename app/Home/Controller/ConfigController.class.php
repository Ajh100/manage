<?php

/*
网站配置
 */
namespace Home\Controller;
use Think\Controller;
class ConfigController extends AdminController{
    
    public function index(){
        $data = M('Config')->select();
        $list = array();
        foreach ($data as $key => $value){
            $list[$value['keys']] = $value['value'];
        }
        $this->assign('list', $list);
        $this->display();
    }
    
    public function save(){
        if(IS_POST){
            $data = I('post.');
            $model = M('Config');
            foreach ($data as $key => $value){
                $vo['value'] = $value;
                $result = $model->where(array('keys' => $key))->save($vo);
            }
            $this->success('保存成功', U('index'));
        }
    }
}
