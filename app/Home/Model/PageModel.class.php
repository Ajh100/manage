<?php

/*
单页内容 page
 */
namespace Home\Model;
use Think\Model;

class PageModel extends Model{
    protected $_validate = array(
        array('title','require','标题必须！'),
        array('classid','require','所属类别必须！'),
        array('content','require','内容必须！')
    );
    
    protected $_auto=array(
        array('addtime','time',1,'function'),
    );
}
