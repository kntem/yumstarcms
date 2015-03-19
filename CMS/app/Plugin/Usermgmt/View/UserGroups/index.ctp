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

<?php
$getPermissions = $this->requestAction('/UserGroupPermissions/tab_access_permission');
$alluser = 0;
$adduser = 0;
$addgroup = 0;
$allgroup = 0;
//pr($getPermissions);
if (!empty($getPermissions)) {
    foreach ($getPermissions as $getPermission) {
        if ($getPermission['UserGroupPermission']['controller'] == 'Users' && $getPermission['UserGroupPermission']['action'] == 'index' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $alluser = 1;
        }
        if ($getPermission['UserGroupPermission']['controller'] == 'Users' && $getPermission['UserGroupPermission']['action'] == 'addUser' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $adduser = 1;
        }
        if ($getPermission['UserGroupPermission']['controller'] == 'UserGroups' && $getPermission['UserGroupPermission']['action'] == 'addGroup' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $addgroup = 1;
        }
        if ($getPermission['UserGroupPermission']['controller'] == 'UserGroups' && $getPermission['UserGroupPermission']['action'] == 'index' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $allgroup = 1;
        }
    }
}
?>

<?
echo $this->Session->flash();
echo $this->element('dashboard');
?>

<div style="margin: 20px 0;">
    <div class="row-fluid">
        <div class="span10"></div>
        <div class="span2">
            <? if ($addgroup == 1) {?>
                <a href='/addGroup'><button class="btn btn-success"><i class="icon-group icon-white"></i> Add Group</button></a>
            <? } ?>
        </div>
    </div>
</div>

<div class="widget widget-blue">
    <div class="widget-title">
        <h3><?php echo __('User Groups'); ?></h3>
    </div>
    <div class="widget-content" id="index">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 70px;"><?php echo __('Group Id');?></th>
                    <th><?php echo __('Name');?></th>
                    <th><?php echo __('Alias Name');?></th>
                    <th style="width: 130px;"><?php echo __('Allow Registration');?></th>
                    <th><?php echo __('Created');?></th>
                    <th style="text-align: center"><?php echo __('Action');?></th>
                </tr>
            </thead>
            <tbody>
        <?php if( !empty($userGroups)) {
                    foreach ($userGroups as $row) {
                        echo "<tr>";
                        echo "<td>".$row['UserGroup']['id']."</td>";
                        echo "<td>".h($row['UserGroup']['name'])."</td>";
                        echo "<td>".h($row['UserGroup']['alias_name'])."</td>";
                        echo "<td>";
                        if ($row['UserGroup']['allowRegistration']) {
                            echo "Yes";
                        } else {
                            echo "No";
                        }
                        echo"</td>";

                        echo "<td>".date('d-M-Y',strtotime($row['UserGroup']['created']))."</td>";
                        echo "<td style='text-align: center'>";

                        echo "<a href='".$this->Html->url('/editGroup/'.$row['UserGroup']['id'])."'><i class='icon-edit icon-white'></i></a> ";
                        if ($row['UserGroup']['id']!=1) {
                            echo $this->Form->postLink("<i class='icon-remove icon-white'></i>",
                                                       array('action' => 'deleteGroup', $row['UserGroup']['id']),
                                                       array('escape' => false, 'confirm' => __('Are you sure you want to delete this group? Delete at your own risk'))
                                                      );
                            //echo $this->Html->tag('i', '', array('class' => 'icon-delete icon-white'));
                            //echo $this->Form->postLink("<i class='icon-group icon-white'></i>", array('action' => 'deleteGroup', $row['UserGroup']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to delete this group? Delete at your own risk')));
                            //echo $this->Form->postLink($this->Html->image(SITE_URL.'usermgmt/img/delete.png', array("alt" => __('Delete'), "title" => __('Delete'))), array('action' => 'deleteGroup', $row['UserGroup']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to delete this group? Delete at your own risk')));
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan=6>No Data</td></tr>";
                } ?>
            </tbody>
        </table>
    </div>
</div>
