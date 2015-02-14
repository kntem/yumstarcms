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
             <h3><?php echo __('Change Password'); ?><span class="umstyle2" style="float:right"><?php echo $this->Html->link(__("Home",true),"/") ?></span></h3>
				
			</div>
			<div class="widget-content">
					<?php echo $this->Form->create('User', array('action' => 'changePassword','class'=>'form-horizontal')); ?>
					<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo __('Old Password');?></label>
						<div class="col-sm-8"><?php echo $this->Form->input("oldpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"required form-control" ))?></div>
						
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo __('New Password');?></label>
						<div class="col-sm-8"><?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"required form-control" ))?></div>
						
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo __('Confirm Password');?></label>
						<div class="col-sm-8"><?php echo $this->Form->input("cpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"required form-control" ))?></div>
					
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label"></label>
						<div class="col-sm-8"><?php echo $this->Form->Submit(__('Change',array('class'=>'btn btn-success')));?></div>
                                        </div>	
					
                            </div>
					<?php echo $this->Form->end(); ?>
        </div>	
				
	
	
<script>
document.getElementById("UserPassword").focus();
</script>