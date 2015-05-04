<?php
if (($this->params['controller'] == "categories")) {
    $active = "active";
}
if (($this->params['controller'] == "items")) {
    $activeitem = "active";
}
if (($this->params['controller'] == "users")) {
    $activeusr = "active";
}
if (($this->params['controller'] == "restaurants")) {
    $activeres = "active";
}
if (($this->params['controller'] == "orders")) {
    $activeord = "active";
}
if (($this->params['controller'] == "userSettings")) {
    $activeset = "active";
}
if (($this->params['controller'] == "OrderItems")) {
    $activeorditm = "active";
}
$getPermissions = $this->requestAction('/UserGroupPermissions/tab_access_permission');
$category = 0;
$restaurant = 0;
$item = 0;
$allgroup = 0;
$grp = 0;
if (!empty($getPermissions)) {
    foreach ($getPermissions as $getPermission) {
        $grp = $getPermission['UserGroupPermission']['user_group_id'];
        if ($getPermission['UserGroupPermission']['controller'] == 'Categories' && $getPermission['UserGroupPermission']['action'] == 'index' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $category = 1;
        }
        if ($getPermission['UserGroupPermission']['controller'] == 'Restaurants' && $getPermission['UserGroupPermission']['action'] == 'index' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $restaurant = 1;
        }
        if ($getPermission['UserGroupPermission']['controller'] == 'Items' && $getPermission['UserGroupPermission']['action'] == 'index' && $getPermission['UserGroupPermission']['allowed'] == 1) {
            $item = 1;
        }
    }
}
?>
<div class="side">

    <div class="sub-sidebar-wrapper">
        <ul class="nav">
<?php if ($grp == 5) { ?>
                <li class="<?php echo (!empty($activeorditm)) ? $activeorditm : ''; ?>"><?php echo $this->Html->link('running Order', '/OrderItems/running_item_index', array('title' => 'Orders')); ?></li>
            <?php } ?>
            <!--<li class="<?php echo (!empty($activeord)) ? $activeord : ''; ?>"><?php echo $this->Html->link('History', '/orders', array('title' => 'Orders')); ?></li>-->
            <?php if ($category == 1) { ?>
<!--                 <li class="<?php echo (!empty($active)) ? $active : ''; ?>"><?php echo $this->Html->link('Categories', '/categories', array('title' => 'Categories')); ?></li>
 -->            <?php } if ($item == 1) { ?>
<!--                 <li class="<?php echo (!empty($activeitem)) ? $activeitem : ''; ?>"><?php echo $this->Html->link('Items', '/items', array('title' => 'Items')); ?></li>
 -->            <?php } if ($grp != 5) { ?>
                <li class="<?php echo (!empty($activeusr)) ? $activeusr : ''; ?>"><?php echo $this->Html->link('Users', '/dashboard', array('title' => 'Users')); ?></li>
            <?php } if ($restaurant == 1) { ?>
                <li class="<?php echo (!empty($activeres)) ? $activeres : ''; ?>"><?php echo $this->Html->link('Businesses', '/restaurants', array('title' => 'Businesses')); ?></li>
            <?php } ?>

            <?php if ($grp == 1) { ?>
                <li class="<?php echo (!empty($activeset)) ? $activeset : ''; ?>"><?php echo $this->Html->link('Settings', '/UserSettings', array('title' => 'UserSettings')); ?></li>
                <li class="<?php echo (!empty($activeset)) ? $activeset : ''; ?>"><?php echo $this->Html->link('History', '/OrderReports/res_report', array('title' => 'Reports')); ?></li>
                <li class="<?php echo (!empty($activeitem)) ? $activeitem : ''; ?>"><?php echo $this->Html->link('Abused Reports', '/suggestions/report_abused', array('title' => 'Abused Reports')); ?></li>
<?php
}
if ($grp == 4) {
    ?>
                <li class="<?php echo (!empty($activeset)) ? $activeset : ''; ?>"><?php echo $this->Html->link('Reports', '/OrderReports/res_report', array('title' => 'Reports')); ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
