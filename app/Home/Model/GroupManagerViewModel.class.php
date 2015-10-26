<?php 
namespace Home\Model;
use Think\Model\ViewModel;
class GroupManagerViewModel extends ViewModel{
	public $viewFields=array(		
            'manager'=>array('_table'=>'tc_manager'),
            'groups_access'=>array('_table'=>'tc_manager_auth_group_access','uid','group_id','_on'=>'manager.uid=groups_access.uid'),
            'groups'=>array('_table'=>'tc_manager_auth_group','_on'=>'groups_access.group_id=groups.id')
	);
}
 ?>