<?php
/*
店铺视图
 */
namespace Home\Model;
use Think\Model\ViewModel;
class SalemanViewModel extends ViewModel{
    public $viewFields = array(
        'saleman' => array('_table'=>'tc_saleman','id','store_id','realname','nickname','weixin','face','zhiwei','telphone','qq','addtime'),
        'store' => array('_table'=>'tc_store','title','id'=>'store_id','_on'=>'saleman.store_id=store.id'),
        'position' => array('_table'=>'tc_position','title'=>'position','_on'=>'saleman.zhiwei=position.id')
    );
}
