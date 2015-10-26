<?php

/*
城市视图
 */
namespace Home\Model;
use Think\Model\ViewModel;

class CityViewModel extends ViewModel{
    public $viewFields = array(
        'city' => array('_table'=>'tc_city','id','title','fullname','pinyin','sort','status'),
        'area' => array('_table'=>'tc_area','title'=>'area_title','pinyin'=>'area_py','_on'=>'city.area_id=area.id')
    );
}