<?php

/*
单页视图
 */
namespace Home\Model;
use Think\Model\ViewModel;

class PageViewModel extends ViewModel{
    public $viewFields = array(
        'page' => array('_table'=>'tc_page','id','classid','title','banner','addtime','sort','status'),
        'pageclass' => array('_table'=>'tc_page_class','title'=>'classtitle','_on'=>'page.classid=pageclass.id')
    );
}
