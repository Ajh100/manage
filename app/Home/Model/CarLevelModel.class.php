<?php

/*
车辆级别
 */
namespace Home\Model;
use Think\Model;
class CarLevelModel extends Model{
    
    protected $_validate = array(
        array('title','require','标题不能为空！'), 
        array('pinyin','require','拼音简写不能为空！'),
        array('title','','标题已经存在！',0,'unique',3), 
        array('pinyin','','拼音简写已经存在！',0,'unique',3),
    );
            
    protected $_auto = array (   
        array('pinyin', 'lower2replace', 3, 'function'),
        array('is_red', 'is_red', 3, 'function'),
        array('is_hot', 'is_hot', 3, 'function'),
        array('is_lock', 'is_lock', 3, 'function'),
    );
    
    public function get_tree(){
        $list = $this->where(array('status'=>0))->select();
    }
    
}
