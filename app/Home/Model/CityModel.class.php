<?php

/*
城市
 */
namespace Home\Model;
use Think\Model;

class CityModel extends Model{
    protected $_validate = array(
        array('area_id','require','所属省份必须！'),
        array('title','require','城市必须！'),
        array('pinyin','require','拼音简写必须！'),
        array('title', '', '城市已经存在', 3, 'unique', self::MODEL_BOTH),
        array('pinyin', '', '拼音简写已经存在', 3, 'unique', self::MODEL_BOTH),
    );
    
    protected $_auto = array(
        array('pinyin', 'lower2replace', 3, 'function')
    );
}
