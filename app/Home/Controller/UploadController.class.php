<?php
/*
上传控制器
 */
namespace Home\Controller;
use Think\Controller;
class UploadController extends AdminController{
    
    public function ajaxupload(){
        $upload = new \Think\Upload();
        $upload->maxSize  = C('UPLOAD_FILE_SIZE');
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
        $data = array();
        $info = $upload->uploadOne($_FILES['Filedata']);
        if(!$info){
            $data = array(
                'msg'=>0,
                "msgbox"=>$upload->getError(),
            );
        }else{
            $data = array(
                'msg'=>1,
                "msgbox"=> $info['savepath'] . $info['savename'],
            );
        }
        echo json_encode($data);       
    }
    
    public function fileupload(){
        $upload = new \Think\Upload();
        $upload->maxSize  = C('UPLOAD_FILE_SIZE') ;
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
        $data = array();
        $info = $upload->uploadOne($_FILES['FileUpload']);
        if(!$info){
            $data = array(
                'msg'=>0,
                "msgbox"=>$upload->getError(),
            );
        }else{
            $data = array(
                'msg'=>1,
                "msgbox"=> $info['savepath'] . $info['savename'],
            );
        }
        echo json_encode($data);       
    }
    
    public function meituupload(){
        
        $upload = new \Think\Upload();
        $upload->maxSize  = C('UPLOAD_FILE_SIZE') ;
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
        $data = array();
        $info = $upload->uploadOne($_FILES['pic']);
        if(!$info) {
            $data = array(
                'msg'=>0,
                "msgbox"=>$upload->getError()
            );
        }else{
            @unlink('.'.$_POST["id"]);
            $data = array(
                'msg'=>1,
                "msgbox"=> '/uploads/' . $info['savepath'] . $info['savename']
            );
        }
        echo json_encode($data);
    }
}
