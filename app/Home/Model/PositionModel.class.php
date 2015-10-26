<?php

namespace Home\Model;
use Think\Model;
/**
职位
 */
class PositionModel extends Model{
    protected $_validate = array(
        array('title','require','职务必须！')
    );
}
