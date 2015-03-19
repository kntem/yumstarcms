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
//check if navigation link is active
function is_page_active($here, $page){
    if (strpos($here,$page) !== false)
        echo "class='active'";
}
?>


<!--<li class="dashboard_links" id="dashboard">-->
<ul class="nav nav-tabs">

    <li <? is_page_active($this->here, "dashboard"); ?> > <?php echo $this->Html->link(__("Dashboard", true), "/dashboard") ?></li>

    <? //   if ($this->UserAuth->isAdmin()) {   ?>

    <?
    if ($alluser == 1) { ?>
        <li <? is_page_active($this->here, "User"); ?> >
            <? echo $this->Html->link(__("Users", true), "/allUsers") ?>
        </li>

    <? }
    if ($allgroup == 1) { ?>
        <li <? is_page_active($this->here, "allGroups"); ?> >
            <?php echo $this->Html->link(__("User Groups", true), "/allGroups"); ?>
        </li>
    <? }
    if ($this->UserAuth->isAdmin()) { ?>
        <li><?php echo $this->Html->link(__("Permissions", true), "/permissions") ?></li>
    <? } ?>

    <li><?php echo $this->Html->link(__("Profile", true), "/viewUser/" . $this->UserAuth->getUserId()) ?></li>

    <li><?php echo $this->Html->link(__("Edit Profile", true), "/editUser/" . $this->UserAuth->getUserId()) ?></li>
    <?php //   } else {  ?>

    <li><?php // echo $this->Html->link(__("Profile", true), "/myprofile") ?></li>
    <?php //   }   ?>

    <li><?php echo $this->Html->link(__("Change Password", true), "/changePassword") ?></li>

    <li><?php echo $this->Html->link(__("Sign Out", true), "/logout") ?></li>
</ul>
