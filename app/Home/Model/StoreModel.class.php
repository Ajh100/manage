<?php

/*
店铺表
 */
namespace Home\Model;
use Think\Model;
class StoreModel extends Model{
    protected $_validate = array(
        array('title','require','店铺名称必须！'),
        array('pinyin','require','拼音简写必须！'),
        array('area','require','省份区域必须！'),
        array('city','require','城市必须！'),
        array('address','require','地址必须！'),
        array('shopkeeper','require','店长(负责人)必须！'),
        array('tel','require','电话必须！'),
        array('coordinate','require','经纬度坐标必须！'),
        array('title', '', '拼店铺已经存在', 3, 'unique', self::MODEL_BOTH),
        array('pinyin', '', '拼音简写已经存在', 3, 'unique', self::MODEL_BOTH),
    );
    
    protected $_auto = array(
        array('pinyin', 'lower2replace', 3, 'function'),
        array('addtime', 'time', 3, 'function')
    );
}