<?php

/*
环保标准
 */
namespace Home\Model;
use Think\Model;
class CarEsidModel extends Model{
 
    protected $_validate = array(
        array('title','require','标题必须！')
    );
    
    protected $_auto = array(
        array('is_red', 'is_red', 3, 'function')
    );
}
