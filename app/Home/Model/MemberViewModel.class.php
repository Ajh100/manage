<?php

/*
用户视图
 */
namespace Home\Model;
use Think\Model\ViewModel;
class MemberViewModel extends ViewModel{
    public $viewFields = array(
        'user' => array('_table'=>'tc_member','uid','account','nickname'=>'userrealname','status'),
        'store' => array('_table'=>'tc_store','title'=>'storename','_on'=>'user.store_id=store.id')
    );
}
