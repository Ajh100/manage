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
class ArticleClassModel extends Model{
    protected $_validate = array(
        array('title','require','标题必须！'),
        array('pinyin','require','拼音简写必须！'),
        array('pinyin', '', '拼音简写已经存在', 3, 'unique', self::MODEL_BOTH),
    );
    protected $_auto = array(
        array('pinyin', 'lower2replace', 3, 'function'),
        array('level', 'get_level', 3, 'function')
    );
}
