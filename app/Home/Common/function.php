<?php

//记录操作日志
function log_write($author, $action, $content){
    $data = array(
        'author'  => $author,
        'action'  => $action,
        'content' => $content,
        'datetime'=> time()
    );
    M('LogManage')->add($data);
}

function authcheck($name, $uid, $type=1, $mode='url', $relation='or'){
    if(!in_array($uid,C('ADMINISTRATOR'))){ 
        $auth=new \Think\Auth();
        return $auth->check($name, $uid, $type, $mode, $relation)?true:false;
    }else{
        return true;
    }
}

function get_carqulityclass_title($id){
    $name = M('CarQualityClass')->where('id = '.$id)->getField('title');
    return $name;    
}

//模型推荐字段is_red
function is_red(){
    if(isset($_REQUEST['is_red'])){
        return 1;
    }else{
        return 0;
    }
}
//模型推荐字段is_red
function is_hot(){
    if(isset($_REQUEST['is_hot'])){
        return 1;
    }else{
        return 0;
    }
}
//模型推荐字段is_red
function is_lock(){
    if(isset($_REQUEST['is_lock'])){
        return 1;
    }else{
        return 0;
    }
}


function getTree(&$data,$pid = 0,$count = 1) {
    if(!isset($data['odl'])){
        $data=array('new'=>array(),'odl'=>$data);
    }
    foreach ($data['odl'] as $k => $v){
        if($v['pid']==$pid){
            $v['level'] = $count;
            $data['new'][]=$v;
            unset($data['odl'][$k]);
            getTree($data,$v['id'],$count+1);
        } 
    }
    return $data['new'] ;
 }
 
function get_level(){
    if(isset($_POST['pid'])){
        return (int)$_POST['pid']+1;
    }
}

function get_store_name($id){
    $data = M('Store')->field('title')->find($id);
    return $data['title'];
}

function get_saleman_name($id){
    $data = M('Saleman')->field('nickname')->find($id);
    return $data['nickname'];
}

//统计车源数量
function get_store_car_count($id){
    $data = M('Car')->field('id')->where('store_id ='.$id)->count('id');
    return $data;
}

function get_saleman_car_count($id){
    $data = M('Car')->field('id')->where('uid ='.$id)->count('id');
    return $data;
}

function get_city_car_count($id){
    $data = M('Car')->field('id')->where('city_id ='.$id)->count('id');
    return $data;
}

function get_area_car_count($id){
    $data = M('Car')->field('id')->where('area_id ='.$id)->count('id');
    return $data;
}