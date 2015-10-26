<?php

namespace Home\Model;
use Think\Model;

/**
质检
 */
class CarQualityModel extends Model{
    protected $_validate = array(
        array('title','require','标题必须！'),
        array('title', '', '项目已经存在', 3, 'unique', self::MODEL_BOTH),
    );
}
