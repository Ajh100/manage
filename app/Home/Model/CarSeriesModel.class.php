<?php

/*
车系表
 */
namespace Home\Model;
use Think\Model;
class CarSeriesModel extends Model{
    
    protected $_validate = array(
        array('title','require','标题必须！'),
        array('brand_id','require','品牌ID必须！'),
        array('letter','require','首字母必须！'),
        array('pinyin','require','拼音简写必须！'),
        array('pinyin', '', '拼音简写已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
    );
    
    protected $_auto = array(
        array('pinyin', 'lower2replace', self::MODEL_BOTH, 'function'),
    );
}
