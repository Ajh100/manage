<?php
namespace Home\Model;
use Think\Model;
/*
文章类别
/**
 * Description of ArticleClassModel
 *
 * @author Administrator
 */
class ArticleModel extends Model{
    protected $_validate = array(
        array('title','require','标题必须！'),
        array('classid','require','所属分类必须！'),
        array('content','require','内容必须！'),
    );
    protected $_auto = array(
        array('pinyin', 'lower2replace', 3, 'function'),
        array('content', 'htmlspecialchars_decode', 3, 'function'),
        array('is_red', 'is_red', 3, 'function'),
        array('is_hot', 'is_hot', 3, 'function'),
        array('addtime', 'time', 1, 'function'),
        array('updatetime', 'time', 2, 'function'),
    );
}
