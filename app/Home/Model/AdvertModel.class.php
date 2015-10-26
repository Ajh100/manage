<?php

/*
广告
 */
namespace Home\Model;
use Think\Model;

class AdvertModel extends Model{
    
    protected $_auto=array(
        array('addtime','time',1,'function'),
    );
}
