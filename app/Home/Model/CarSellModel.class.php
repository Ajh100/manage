<?php

/*
帮卖
 */
namespace Home\Model;
use Think\Model;

class CarSellModel extends Model{
    
    protected $_validate = array(
        array('phone','require','手机号码必须'),
    );

    protected $_auto = array(
        array('addtime','time',1,'function'),
    );
}
