<?php
/*
车源试图
 */
namespace Home\Model;
use Think\Model\ViewModel;

class CarViewModel extends ViewModel{
    public $viewFields = array(
        'car' => array('_table'=>'tc_car','id','title','uid','store_id','cover','owner','tel','status','addtime','update_time','clicktimes'),
        'user' => array('_table'=>'tc_member','uid','account','nickname'=>'userrealname','_on'=>'car.uid=user.uid'),
        'store' => array('_table'=>'tc_store','title'=>'storename','_on'=>'car.store_id=store.id'),
        //'city' => array('_table'=>'tc_city','title'=>'cityname','_on'=>'car.city_id=city.id'),
        //'area' => array('_table'=>'tc_area','title'=>'areaname','_on'=>'car.area_id=area.id')
    );
}
