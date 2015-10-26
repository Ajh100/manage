<?php
/*
国别试图
 */
namespace Home\Model;
use Think\Model\ViewModel;
class CarSubBrandViewModel extends ViewModel{
	public $viewFields = array(
            'subbrand' => array('_table'=>'tc_car_sub_brand','id','title','bid','sort','pinyin','status'),
            'brand' => array('_table'=>'tc_car_brand','title'=>'brandtitle','_on'=>'brand.id=subbrand.bid'),
	);
}