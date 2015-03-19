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

    <ul class="breadcrumb">
        <li><a href="/dashboard">Dashboard</a> <span class="divider">/</span></li>
        <li><a href="allUsers">Users</a> <span class="divider">/</span></li>
        <li class="active">Add User</li>
    </ul>

    <?php echo $this->Form->create('User',
                                   array('action' => 'addUser','class'=>'form-horizontal',
                                       'inputDefaults' => array(
                                           'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))
                                   );?>
	<div class="widget widget-blue">
        <div class="widget-title">
            <h3><?php echo __('Add User'); ?></h3>
        </div>
			
        <div class="widget-content">
					
        <?php
            $user_type = $this->UserAuth->getUser();
            $user_type = $user_type['UserGroup']['name'];
            if (($user_type == 'Admin') and (count($userGroups) > 2)){ ?>
                <div class="control-group <? if (isset($this->validationErrors['User']['user_group_id'])) { ?> error<? } ?>">
                    <label class=" control-label"><?php echo __('Group');?><font color='red'>*</font></label>
                    <div class="controls"><?php echo $this->Form->input("user_group_id" ,array('type' => 'select', 'label' => false,'div' => false,'class'=>"required form-control",'onchange'=>'selectres(this.options[this.selectedIndex].value)' ))?></div>
                </div>

                <div class="control-group" <? if (isset($this->validationErrors['User']['rest_id'])) { ?> error<? } ?> id="restsid" style="display:none;">
                    <label class=" control-label"><?php echo __('Restaurant');?><font color='red'>*</font></label>
                    <div class="controls"><?php echo $this->Form->input("rest_id" ,array('type' => 'select', 'label' => false,'div' => false,'class'=>"required form-control", 'options' => $restaurant ))?>
                    </div>
                </div>
            <?php }
            else{ ?>
                <div class="control-group <? if (isset($this->validationErrors['User']['rest_id'])) { ?> error<? } ?>">
                    <label class=" control-label"><?php echo __('Restaurant');?><font color='red'>*</font></label>
                    <div class="controls"><?php echo $this->Form->input("rest_id" ,array('type' => 'select', 'label' => false,'div' => false,'class'=>"required form-control", 'options' => $restaurant ))?></div>
                </div>
            <?php } ?>
            <div class="control-group <? if (isset($this->validationErrors['User']['username'])) { ?> error<? } ?>">
                    <label class=" control-label"><?php echo __('Username');?><font color='red'>*</font></label>
                    <div class="controls"><?php echo $this->Form->input("username" ,array('label' => false,'div' => false,'class'=>"required form-control" ))?></div>
                </div>

                <div class="control-group <? if (isset($this->validationErrors['User']['first_name'])) { ?> error<? } ?>">
                    <label class=" control-label"><?php echo __('First Name');?><font color='red'>*</font></label>
                    <div class="controls"><?php echo $this->Form->input("first_name" ,array('label' => false,'div' => false,'class'=>"required form-control" ))?></div>
                </div>

                <div class="control-group <? if (isset($this->validationErrors['User']['last_name'])) { ?> error<? } ?>">
                    <label class=" control-label"><?php echo __('Last Name');?><font color='red'>*</font></label>
                    <div class="controls"><?php echo $this->Form->input("last_name" ,array('label' => false,'div' => false,'class'=>"required form-control" ))?></div>
                </div>

                <div class="control-group <? if (isset($this->validationErrors['User']['email'])) { ?> error<? } ?>">
                    <label class=" control-label"><?php echo __('Email');?><font color='red'>*</font></label>
                    <div class="controls"><?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"required form-control" ))?></div>
                </div>

                <div class="control-group <? if (isset($this->validationErrors['User']['password'])) { ?> error<? } ?>">
                    <label class=" control-label"><?php echo __('Password');?><font color='red'>*</font></label>
                    <div class="controls"><?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"required form-control" ))?></div>
                </div>

                <div class="control-group <? if (isset($this->validationErrors['User']['cpassword'])) { ?> error<? } ?>">
                    <label class=" control-label"><?php echo __('Confirm Password');?><font color='red'>*</font></label>
                    <div class="controls"><?php echo $this->Form->input("cpassword" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"required form-control" ))?></div>
                </div>

                <div class="control-group">
                    <label class=" control-label"></label>
                    <div class="controls"><?php echo $this->Form->Submit(__('Add User'),array('class' => 'btn btn-success', 'id' => 'btnsubmit'));?></div>
                </div>
        </div>
    </div>

    <?php echo $this->Form->end(); ?>
				
	

<script>
document.getElementById("UserUserGroupId").focus();
function selectres(data){
    if(data == 5){
        $('#restsid').show();
    }
}
</script>
