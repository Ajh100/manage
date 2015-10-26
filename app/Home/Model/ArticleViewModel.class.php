<?php

namespace Home\Model;
use Think\Model\ViewModel;
class ArticleViewModel extends ViewModel{
    public $viewFields = array(
        'article' => array('_table'=>'tc_article','id','title','classid','sort','is_red','is_hot','addtime'),
        'class' => array('_table'=>'tc_article_class','title'=>'classtitle','_on'=>'article.classid=class.id')
    );
}