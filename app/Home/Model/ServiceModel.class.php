<?php

namespace Home\Model;
use Think\Model;

/**
公司服务
 */
class ServiceModel extends Model{
    protected $_validate = array(
        array('title','require','标题必须！')
    );
}
