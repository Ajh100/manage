<?php

namespace Home\Model;
use Think\Model\ViewModel;
class NoticeViewModel extends ViewModel{
    public $viewFields = array(
        'notice' => array('_table'=>'tc_notice','id','title','classid','addtime'),
        'class' => array('_table'=>'tc_notice_class','title'=>'classtitle','_on'=>'notice.classid=class.id')
    );
}