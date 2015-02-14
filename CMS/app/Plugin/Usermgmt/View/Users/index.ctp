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
<div style="margin: 20px 0;">
    <?php echo $this->Form->create('Search', array('class' => 'form-inline ', 'id' => 'item_search')); ?>
        <div class="row">
        <div class="col-sm-12">
    <div class="form-group">                               
        <?php echo $this->Form->input('Search.name', array('type' => 'text', 'class' => 'form-control', 'label' => false,'placeholder'=>'User Name')); ?>    
    </div>
    <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'search')); ?>   
    <?php
    if (isset($flag)) {
        if ($flag == 'true') {
            echo $this->Html->link('View All', '/allUsers', array('class' => 'btn btn-primary'));
        }
    }
    echo $this->Form->end();
    ?>    </div>    
</div>
</div>
<div class="widget widget-blue">
    <div class="widget-title">
        <h3><?php echo __('All Users'); ?><span class="home_link" style="float:right"><?php echo $this->Html->link(__("Home", true), "/") ?></span></h3>
    </div>
    <div class="widget-content" id="index">
        <div class="table-responsive">
            <table class="table table-bordered table-hover all_users_table" cellspacing="0" cellpadding="0" width="100%" border="0" >
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
                            echo "<td>";
                            echo "<span class='icon'><a href='" . $this->Html->url('/viewUser/' . $row['User']['id']) . "'><img src='" . SITE_URL . "usermgmt/img/view.png' border='0' alt='View' title='View'></a></span>";
                            echo "<span class='icon'><a href='" . $this->Html->url('/editUser/' . $row['User']['id']) . "'><img src='" . SITE_URL . "usermgmt/img/edit.png' border='0' alt='Edit' title='Edit'></a></span>";
                            echo "<span class='icon'><a href='" . $this->Html->url('/changeUserPassword/' . $row['User']['id']) . "'><img src='" . SITE_URL . "usermgmt/img/password.png' border='0' alt='Change Password' title='Change Password'></a></span>";
                            if ($row['User']['email_verified'] == 0) {
                                echo "<span class='icon'><a href='" . $this->Html->url('/usermgmt/users/verifyEmail/' . $row['User']['id']) . "'><img src='" . SITE_URL . "usermgmt/img/email-verify.png' border='0' alt='Verify Email' title='Verify Email'></a></span>";
                            }
                            if ($row['User']['active'] == 0) {
                                echo "<span class='icon'><a href='" . $this->Html->url('/usermgmt/users/makeActiveInactive/' . $row['User']['id'] . '/1') . "'><img src='" . SITE_URL . "usermgmt/img/dis-approve.png' border='0' alt='Make Active' title='Make Active'></a></span>";
                            } else {
                                echo "<span class='icon'><a href='" . $this->Html->url('/usermgmt/users/makeActiveInactive/' . $row['User']['id'] . '/0') . "'><img src='" . SITE_URL . "usermgmt/img/approve.png' border='0' alt='Make Inactive' title='Make Inactive'></a></span>";
                            }
                            if ($row['User']['id'] != 1 && $row['User']['username'] != 'Admin') {
                                echo $this->Form->postLink($this->Html->image(SITE_URL . 'usermgmt/img/delete.png', array("alt" => __('Delete'), "title" => __('Delete'))), array('action' => 'deleteUser', $row['User']['id']), array('escape' => false, 'confirm' => __('Are you sure you want to delete this user?')));
                            }
                            echo "</td>";
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
        <span id="tablePagination_perPage"><?php
                    if (isset($this->params->query['limit'])) {
                        $limit = $this->params->query['limit'];
//            echo "Limit : ".$limit;
                    } else {
                        $limit = 5;
                    }
                    $options = array('5' => 5, '10' => 10, '20' => 20);

                    echo $this->Form->create(array('type' => 'get'));

                    echo $this->Form->select('limit', $options, array(
                        'value' => $limit,
                        'default' => $limit,
                        'onChange' => 'this.form.submit();',
                        'name' => 'limit',
                        'id' => 'tablePagination_rowsPerPage',
                        'class' => 'per_page span2'
                            )
                    );
                    echo $this->Form->end();
                    ?>
            <span class="per_page">per page</span>                    
        </span>
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