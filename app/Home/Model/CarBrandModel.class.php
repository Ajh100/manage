<?php
/*
汽车品牌
 */
namespace Home\Model;
use Think\Model;
class CarBrandModel extends Model{
    
    protected $_validate = array(
        array('title','require','标题必须！'),
        array('letter','require','首字母必须！'),
        array('pinyin','require','拼音简写必须！'),
        array('pinyin', '', '拼音简写已经存在', 3, 'unique', self::MODEL_BOTH),
    );
    
    protected $_auto = array(
        array('pinyin', 'lower2replace', 3, 'function'),
        array('is_red', 'is_red', 3, 'function'),
        array('is_hot', 'is_hot', 3, 'function'),
        array('is_lock', 'is_lock', 3, 'function'),
    );

}
