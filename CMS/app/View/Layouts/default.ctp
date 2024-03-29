<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $this->fetch('title'); ?>
        </title>
        <link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Oswald:300,400,700|Open+Sans:400,700,300|Roboto:100,300,400,700|Roboto+Condensed:300,400,700' rel='stylesheet' type='text/css'>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Form->hidden('SITE_URL', array('value' => SITE_URL, 'id' => 'SITE_URL'));
        //echo $this->Html->css('cake.generic');
        echo $this->Html->css(array('style',
                                    'ui.switchbutton.min',
                                    'jquery.fancybox',
                                    'new1',
                                    'new2',
                                    //'new3',
                                    'new4',
                                    'new5'));
        echo $this->Html->css('/usermgmt/css/umstyle');
        echo $this->Html->script(array('3315666c34de7c122079bfa9bb9bfa9f'));
        //                               'c81813dd5f2238060c9ddecda9683907',));
        echo $this->Html->script(array('jquery.validate',
                                       'jquery.min',
                                       'jquery.tablesorter.min',
                                       'jquery.tablePagination',
                                       'jquery.fancybox',
                                       'c81813dd5f2238060c9ddecda9683907',
                                       'jquery.bpopup.min'));
        echo $this->fetch('script');
        echo $this->Html->script('/bootstrap/js/bootstrap.min.js');
        echo $this->fetch('meta');
        echo $this->Html->css('/bootstrap/css/bootstrap.min.css');
        echo $this->Html->css('/bootstrap/css/bootstrap-responsive.min.css');
        echo $this->fetch('css');
        ?>
    </head>
    <body>
        <div id="container" class="page_wrapper">
            <?php
            $user_id = $this->UserAuth->getUserId();
            if (!empty($user_id)) {
                ?>
                <input type="hidden" value="<?php echo WWW_ROOT ?>" id="path_webroot"/>

                <div class="all-wrapper fixed-header left-menu"><?php } ?>
                <div id="header">

                    <?php
                    if (!empty($user_id)) {
                        ?>
                        <?php echo $this->element('header'); ?>
                    <?php } ?>
    <!--<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>-->
                </div>
                <?php if (!empty($user_id)) {
                    ?>
                    <?php echo $this->element('sidebar1'); ?>
                <?php } ?>


                <?php echo $this->Session->flash(); ?>
                <?php if (!empty($user_id)) {
                    ?>
                    <div class="main-content">
                        <?php
                    }
                    echo $this->fetch('content');
                    ?>
                    <?php // echo $this->element('sql_dump');   ?>

                </div>
                    
                <div id="footer">
                    <?php
                    // echo $this->Html->link(
//					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
//					'http://www.cakephp.org/',
//					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
//				);
                    ?>
                    <p>
                        <?php // echo $cakeVersion;    ?>
                    </p>
                </div>
                <?php if (!empty($user_id)) {
                    ?>
                </div> <?php } ?>
        </div>

    </body>
</html>
