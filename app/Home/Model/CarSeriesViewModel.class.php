<?php
/*
车系视图
 */
namespace Home\Model;
use Think\Model\ViewModel;
class CarSeriesViewModel extends ViewModel{
    public $viewFields = array(
        'series' => array('_table'=>'tc_car_series','id','title','brand_id','sort','pinyin','is_lock','status'),
        'brand' => array('_table'=>'tc_car_brand','title'=>'brandtitle','_on'=>'series.brand_id=brand.id'),
        'subbrand' => array('_table'=>'tc_car_sub_brand','title'=>'subbtitle','_on'=>'subbrand.id=series.sub_bid')
    );
}
