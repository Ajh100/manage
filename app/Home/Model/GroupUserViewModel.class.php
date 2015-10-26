<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class GroupUserViewModel extends ViewModel{
	public $viewFields = array(		
		'user'=>array('_table'=>'tc_user','uid'=>'mid','username'),		
		'groups'=>array('_table'=>'tc_user_auth_group_access','uid','group_id','_on'=>'user.uid=groups.uid'),
		);
}
 ?>