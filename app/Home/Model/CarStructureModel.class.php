<?php
/*
车身结构
 */
namespace Home\Model;
use Think\Model;
class CarStructureModel extends Model{
    
    protected $_validate = array(
        array('title','require','标题不能为空！'), 
        array('pinyin','require','拼音简写不能为空！'),
        array('title','','标题已经存在！',0,'unique',3), 
        array('pinyin','','拼音简写已经存在！',0,'unique',3),
    );
    
    protected $_auto = array(
        array('pinyin', 'lower2replace', 3, 'function'),
        array('addtime','time',3,'function'),
    );
}
