<?php

namespace Home\Model;
use Think\Model;

/**
通知
 */
class NoticeModel extends Model{
    protected $_validate = array(
        array('title','require','标题必须！'),
        array('classid','require','所属分类必须！'),
        array('content','require','内容必须！'),
    );
    protected $_auto = array(
        array('addtime', 'time', 1, 'function')
    );
}
