<?php

namespace Home\Model;
use Think\Model\ViewModel;

class CarClassViewModel extends ViewModel{

    public $viewFields = array(
        'carclass' => array('_table'=>'tc_car_class','id','title','brand_id','sub_brandid','series_id','style_id','output','gearbox','sort','status'),
        'series' => array('_table'=>'tc_car_series','title'=>'seriestitle','_on'=>'series.id=carclass.series_id'),
        'brand' => array('_table'=>'tc_car_brand','title'=>'brandtitle','_on'=>'brand.id=carclass.brand_id'),
        'subbrand' => array('_table'=>'tc_car_sub_brand','title'=>'subbtitle','_on'=>'subbrand.id=carclass.sub_brandid'),
        'year' => array('_table'=>'tc_car_year','title'=>'yeartitle','_on'=>'year.id=carclass.style_id')
    );
    
}
