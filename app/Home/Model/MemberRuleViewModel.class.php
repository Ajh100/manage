<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class MemberRuleViewModel extends ViewModel{
	public $viewFields=array(		
		'rule'=>array('_table'=>'tc_member_auth_rule','id','name','title','type','condition'=>'term','status','mid'),
		//condition必须别名,否则出错
		'modules'=>array('_table'=>'tc_member_modules','moduleName','_on'=>'rule.mid=modules.id')
		);
}
 ?>