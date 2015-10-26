<?php

/*
省份区域
 */
namespace Home\Model;
use Think\Model;

class AreaModel extends Model{
    protected $_validate = array(
        array('title','require','省份区域必须！'),
        array('pinyin','require','拼音简写必须！'),
        array('title', '', '省份区域已经存在', 3, 'unique', self::MODEL_BOTH),
        array('pinyin', '', '拼音简写已经存在', 3, 'unique', self::MODEL_BOTH),
    );
    
    protected $_auto = array(
        array('pinyin', 'lower2replace', 3, 'function')
    );
}
