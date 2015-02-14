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
        if ($getPermission['UserGroupPermission']['controller'] == 'Groups' && $getPermission['UserGroupPermission']['action'] == 'allGroups' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $addgroup = 1;
        }
        if ($getPermission['UserGroupPermission']['controller'] == 'Groups' && $getPermission['UserGroupPermission']['action'] == 'index' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $allgroup = 1;
        }
    }
}
?>
<div class="dashboard_links" id="dashboard">
    <div><?php echo $this->Html->link(__("Dashboard", true), "/dashboard") ?></div>
    <?php //   if ($this->UserAuth->isAdmin()) {   ?>
    <?php if ($adduser == 1) { ?>
        <div><?php echo $this->Html->link(__("Add User", true), "/addUser"); ?></div>
    <?php } if ($alluser == 1) { ?>
        <div><?php echo $this->Html->link(__("All Users", true), "/allUsers") ?></div>
    <?php } if ($addgroup == 1) { ?>
        <div><?php echo $this->Html->link(__("Add Group", true), "/addGroup") ?></div>
    <?php } if ($allgroup == 1) { ?>
        <div><?php echo $this->Html->link(__("All Groups", true), "/allGroups"); ?></div>
    <?php } if ($this->UserAuth->isAdmin()) { ?>
        <div><?php echo $this->Html->link(__("Permissions", true), "/permissions") ?></div>
    <?php } ?>
    <div><?php echo $this->Html->link(__("Profile", true), "/viewUser/" . $this->UserAuth->getUserId()) ?></div>
    <div><?php echo $this->Html->link(__("Edit Profile", true), "/editUser/" . $this->UserAuth->getUserId()) ?></div>
    <?php //   } else {  ?>
    <div><?php // echo $this->Html->link(__("Profile", true), "/myprofile") ?></div>
    <?php //   }   ?>
    <div><?php echo $this->Html->link(__("Change Password", true), "/changePassword") ?></div>
    <div><?php echo $this->Html->link(__("Sign Out", true), "/logout") ?></div>
</div>