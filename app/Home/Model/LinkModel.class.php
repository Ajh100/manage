<?php

/*
友情链接
 * table tc_link
 */
namespace Home\Model;
use Think\Model;
class LinkModel extends Model{
    protected $_validate = array(
        array('title','require','标题必须！'),
        array('site_url','require','链接网址必须！'),
    );
    
    protected $_auto=array(
        array('addtime','time',1,'function'),
    );
}
