<?php
/*
	This file is part of UserMgmt.

	Author: Chetan Varshney (http://ektasoftwares.com)

	UserMgmt is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	UserMgmt is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
?>

	<?php echo $this->Session->flash(); ?>
	<?php echo $this->element('dashboard'); ?>
	<div class="widget widget-blue">
	 <div class="widget-title">
			<h3><?php echo __('Edit User'); ?>
				<span class="" style="float:right"><?php echo $this->Html->link(__("Home",true),"/") ?></span>
                        </h3>
			</div>
			<div class="widget-content">
					<?php echo $this->Form->create('User',array('class'=>'form-horizontal')); ?>
					<?php echo $this->Form->input("id" ,array('type' => 'hidden', 'label' => false,'div' => false))?>
			<?php $user_type = $this->UserAuth->getUser();
        $user_type = $user_type['UserGroup']['name'];
        if($user_type == 'Admin'){?>
    
                                            <?php   if (count($userGroups) >2) { ?>
						<div class="form-group">
							<label class="col-sm-4 control-label"><?php echo __('Group');?><font color='red'>*</font></label>
							<div class="col-sm-8" ><?php echo $this->Form->input("user_group_id" ,array('type' => 'select', 'label' => false,'div' => false,'class'=>"required form-control" ))?></div>
							
						</div>
			<?php   }   ?>
                                    	<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo __('Restaurant');?><font color='red'>*</font></label>
						<div class="col-sm-8" ><?php echo $this->Form->input("rest_id" ,array('type' => 'select', 'label' => false,'div' => false,'class'=>"required form-control", 'options' => $restaurant ))?> </div>
						
        </div><?php }?>
					<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo __('Username');?><font color='red'>*</font></label>
						<div class="col-sm-8" ><?php echo $this->Form->input("username" ,array('label' => false,'div' => false,'class'=>"required form-control" ))?></div>
						
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo __('First Name');?><font color='red'>*</font></label>
						<div class="col-sm-8" ><?php echo $this->Form->input("first_name" ,array('label' => false,'div' => false,'class'=>"required form-control" ))?></div>
					
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo __('Last Name');?><font color='red'>*</font></label>
						<div class="col-sm-8" ><?php echo $this->Form->input("last_name" ,array('label' => false,'div' => false,'class'=>"required form-control" ))?></div>
						
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo __('Email');?><font color='red'>*</font></label>
						<div class="col-sm-8" ><?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"required form-control" ))?></div>
						
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"></label>
						<div class="col-sm-8"><?php echo $this->Form->Submit(__('Update User',array('class'=>'btn btn-success')));?></div>
						
					</div>
                        </div>
					<?php echo $this->Form->end(); ?>
				
			</div>
	
	
<script>
document.getElementById("UserUserGroupId").focus();
</script>