<script type="text/javascript">
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
</script>

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
<?
echo $this->Session->flash();
echo $this->element('dashboard');

$getPermissions = $this->requestAction('/UserGroupPermissions/tab_access_permission');
$alluser = 0;
$adduser = 0;
//pr($getPermissions);
if (!empty($getPermissions)) {
    foreach ($getPermissions as $getPermission) {
        if ($getPermission['UserGroupPermission']['controller'] == 'Users' && $getPermission['UserGroupPermission']['action'] == 'index' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $alluser = 1;
        }
        if ($getPermission['UserGroupPermission']['controller'] == 'Users' && $getPermission['UserGroupPermission']['action'] == 'addUser' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $adduser = 1;
        }
    }
}

?>
<div style="margin: 20px 0;">
    <div class="row-fluid">
        <div class="span4">
                <?php echo $this->Form->create('Search', array('class' => 'form-inline ', 'id' => 'item_search')); ?>
                <div class="input-append">
                    <?
                        echo $this->Form->input('Search.name',
                                                array('type' => 'text',
                                                      'div' => false,
                                                      'class' => 'span12',
                                                      'id' => 'appendedInputButtons',
                                                      'label' => false,
                                                      'placeholder'=>'Search User Name'));
                        echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'search'));
                        if (isset($flag) and ($flag == 'true')) {
                            echo $this->Html->link('View All', '/allUsers', array('class' => 'btn btn-primary'));
                        }
                        echo $this->Form->end();
                    ?>
                </div>
            </div>
        <div class="span8">
            <? if ($adduser == 1) { ?>
                <a href='/addUser'><button class="btn btn-success"><i class="icon-user icon-white"></i> Add User</button></a>
            <? } ?>
        </div>
    </div>

</div>

<div class="widget widget-blue">
    <div class="widget-title">
        <h3><?php echo __('Users'); ?></h3>
    </div>
    <div class="widget-content" id="index">

        <div class="table-responsive">
            <table class="table table-bordered table-hover all_users_table" >
                <thead>
                    <tr>
                        <th><?php echo __('SL'); ?></th>
                        <th><?php echo __('Name'); ?></th>
                        <th><?php echo __('Username'); ?></th>
                        <th><?php echo __('Email'); ?></th>
                        <th><?php echo __('Group'); ?></th>
                        <th><?php echo __('Email Verified'); ?></th>
                        <th><?php echo __('Status'); ?></th>
                        <th><?php echo __('Created'); ?></th>
                        <th><?php echo __('Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($users)) {
                        $sl = 0;
                        foreach ($users as $row) {
                            $sl++;
                            echo "<tr>";
                            echo "<td>" . $sl . "</td>";
                            echo "<td>" . h($row['User']['first_name']) . " " . h($row['User']['last_name']) . "</td>";
                            echo "<td>" . h($row['User']['username']) . "</td>";
                            echo "<td>" . h($row['User']['email']) . "</td>";
                            echo "<td>" . h($row['UserGroup']['name']) . "</td>";
                            echo "<td>";
                            if ($row['User']['email_verified'] == 1) {
                                echo "Yes";
                            } else {
                                echo "No";
                            }
                            echo"</td>";
                            echo "<td>";
                            if ($row['User']['active'] == 1) {
                                echo "Active";
                            } else {
                                echo "Inactive";
                            }
                            echo"</td>";
                            echo "<td>" . date('d-M-Y', strtotime($row['User']['created'])) . "</td>";

                            ?>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Options <b class="caret"></b> </a>
                                    <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel" align="left">

                                        <li>
                                            <?php echo "<a href='" . $this->Html->url('/viewUser/' . $row['User']['id']) . "'><i class='icon-user icon-white'></i> View User</a>"; ?>
                                        </li>
                                        <li><?php echo "<a href='" . $this->Html->url('/editUser/' . $row['User']['id']) . "'><i class='icon-edit icon-white'></i> Edit User</a>";?>
                                        <li><?php echo "<a href='" . $this->Html->url('/changeUserPassword/' . $row['User']['id']) . "'><i class='icon-lock icon-white'></i> Change Password</a>"; ?></li>
                                        <? if ($row['User']['email_verified'] == 0) { ?>
                                            <li><?php echo "<a href='" . $this->Html->url('/usermgmt/users/verifyEmail/' . $row['User']['id']) . "'><i class='icon-envelope icon-white'></i> Verify e-mail</a>"; ?></li>
                                        <? } ?>

                                        <? if ($row['User']['active'] == 0) { ?> <li>
                                            <?php echo "<a href='" . $this->Html->url('/usermgmt/users/makeActiveInactive/' . $row['User']['id'] . '/1') . "'><i class='icon-ok icon-white'></i> Activate User</a>"; ?></li>
                                        <? }
                                        else { ?> <li>
                                            <?php echo "<a href='" . $this->Html->url('/usermgmt/users/makeActiveInactive/' . $row['User']['id'] . '/0') . "'><i class='icon-off icon-white'></i> Deactivate User</a>"; ?></li>
                                        <? } ?>

                                        <li role="presentation" class="divider"></li>
                                        <? if ($row['User']['id'] != 1 && $row['User']['username'] != 'Admin') { ?>
                                            <li><?php echo $this->Form->postLink("<i class='icon-remove icon-white'></i> Remove user", array('action' => 'deleteUser', $row['User']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to remove this user?'))); ?></li>
                                        <? } ?>
                                        <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
                                    </ul>
                                </div>

                            </td>
                            <?
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan=10><br/><br/>No Data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination_outer pagination pagination-right pagination-mini" id="tablePagination">
        <div id="tablePagination_perPage" style="margin-right:5px;">
        <?php
            if (isset($this->params->query['limit'])) {
                $limit = $this->params->query['limit'];
//            echo "Limit : ".$limit;
            } else {
                $limit = 5;
            }
            $options = array('5' => 5, '10' => 10, '20' => 20);

            echo $this->Form->create(array('type' => 'get'));

            echo $this->Form->select('limit', $options, array(
                                     'value'     => $limit,
                                     'default'   => $limit,
                                     'onChange'  => 'this.form.submit();',
                                     'name'      => 'limit',
                                     'id'        => 'tablePagination_rowsPerPage',
                                     'class'     => 'per_page span2',
                                     'style'     => 'width:auto'
                                     )
                                    );
            echo $this->Form->end();
        ?>
            <small class="per_page">per page</small>
        </div>
        <ul id="tablePagination_paginater">
            <li>  <?php echo $this->paginator->first('|< first'); ?> </li>
            <li>  <?php echo $this->paginator->prev('<< prev', null, null, array('class' => 'prev disabled')); ?> </li>
            <li>   <?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a', 'escape' => false)); ?> </li>
            <li>   <?php echo $this->paginator->next('next >>', null, null, array('class' => 'next disabled')); ?> </li>
            <li>  <?php echo $this->paginator->last('last >|'); ?> </li>
            <li class="no_of_page"><?php echo $this->Paginator->counter(); ?></li>

        </ul>
    </div>
</div>
