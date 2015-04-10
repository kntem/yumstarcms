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

<div class="container">
    <?php echo $this->Form->create('User', array('action' => 'login')); ?>
<!--    <div class="all-wrapper no-menu-wrapper light-bg">
        <div class="login-logo-w">
        <a class="logo">
            <?// echo $this->Html->image('yumstar-logo-small.png', array('alt' => 'Yumstar')); ?>
        </a>
    </div>
-->
    <div class="row" style="margin-top:40px;">
        <div class="span4 offset4">

            <div class="widget widget-blue">
            <div class="widget-title">
                <h3 class="text-center lead"> Sign in to continue </h3>
            </div>
            <div class="widget-content">
                <center>
                    <img class="profile-img" src="/img/yumstar-logo-small.png" alt="" style="height:120px">
                </center>

                <?php echo $this->Session->flash(); ?>
                <form action="#" role="form">
                    <hr/>
                    <div class="form-group relative-w">
                        <div class="input-prepend">
                            <span class="add-on" style="height: 30px; width: 30px;"><i class="icon-user input-abs-icon" style="vertical-align: -7px; background-image: none;"></i></span>
                            <?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"form-control span3", 'style' => "min-height: 30px !important; height: 20 px;"))?>
                            <!--<input type="email" class="form-control" placeholder="Enter email">-->

                        </div>
                    </div>
                    <div class="form-group relative-w">
                        <div class="input-prepend">
                            <span class="add-on" style="height: 30px; width: 30px;"><i class="icon-lock input-abs-icon" style="vertical-align: -7px; background-image: none;"></i></span>
                        <?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"form-control span3", 'style' => "min-height: 30px !important; height: 20 px;"))?>
                        <!--<input type="password" class="form-control" placeholder="Password">-->
                        </div>
                    </div>
            <div class="form-group relative-w">
            <?php
                $options = array(array('name' => 'Admin', 'value' => '1'),
                                 array('name' => 'Buisness Owner', 'value' => '4'),
                                 array('name' => 'Barristas/Cooks', 'value' => '5'),
                                 );
                echo $this->Form->input('user_type',array('type' => 'select',
                                                          'options' => $options,
                                                          'class' => 'form-control',
                                                          'label'=>FALSE));
            ?>
                 <?php //  echo $this->Form->select('field', array("Admin","Buisness Owner","Bar/cuisine Owner","class"=>"form-control")); ?>
                <?php // echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"form-control" ))?>
              <!--<input type="password" class="form-control" placeholder="Password">-->
              <!--<i class="icon-lock input-abs-icon"></i>-->
            </div>
<!--
            <a href="index.html" class="btn btn-primary btn-rounded btn-iconed">
              <span>Log me in</span>-->
            <div class="form-group">

              <?php echo $this->Form->Submit(__('Log me in'),array('class'=>'btn btn-primary btn-large btn-danger btn-block',
                                                                   'style' => "-webkit-box-shadow: none;
                                                                               -moz-box-shadow: none;
                                                                               box-shadow: none;
                                                                               background-image:none;
                                                                               border:0;"));?>
            </div>

            <div class="form-group" style="margin-top: 10px;">
                  <?php echo $this->Form->input("remember me" ,array("type"=>"checkbox"));?>
            </div>
            <!--</a>-->
<!--            <div class="no-account-yet">
              Don't have an account yet? <a href="register.html">Register Now</a>
            </div>-->
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!--<div class="umtop">
	<?php echo $this->Session->flash(); ?>
	<div class="um_box_up"></div>
	<div class="um_box_mid">
		<div class="um_box_mid_content">
			<div class="um_box_mid_content_top">
				<span class="umstyle1"><?php echo __('Sign In or'); ?></span>
				<span  class="umstyle2"><?php echo $this->Html->link(__("Sign Up",true),"/register") ?></span>
				<span class="umstyle2" style="float:right"><?php echo $this->Html->link(__("Home",true),"/") ?></span>
				<div style="clear:both"></div>
			</div>
			<div class="umhr"></div>
			<div class="um_box_mid_content_mid" id="login">
				<div class="um_box_mid_content_mid_left">
					<?php echo $this->Form->create('User', array('action' => 'login')); ?>
					<div>
						<div class="umstyle3"><?php echo __('Email / Username');?></div>
						<div class="umstyle4" ><?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"umstyle5" ))?></div>
						<div style="clear:both"></div>
					</div>
					<div>
						<div class="umstyle3"><?php echo __('Password');?></div>
						<div class="umstyle4"><?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"umstyle5" ))?></div>
						<div style="clear:both"></div>
					</div>
					<div>
					<?php   if(!isset($this->request->data['User']['remember']))
								$this->request->data['User']['remember']=true;
					?>
						<div class="umstyle3"><?php echo __('Remember me');?></div>
						<div class="umstyle4"><?php echo $this->Form->input("remember" ,array("type"=>"checkbox",'label' => false))?></div>
						<div style="clear:both"></div>
					</div>
					<div>
						<div class="umstyle3"></div>
						<div class="umstyle4"><?php echo $this->Form->Submit(__('Sign In'));?></div>
						<div style="clear:both"></div>
					</div>
					<?php echo $this->Form->end(); ?>
					<div  align="left"><?php echo $this->Html->link(__("Forgot Password?",true),"/forgotPassword",array("class"=>"style30")) ?></div>
					<div  align="left"><?php echo $this->Html->link(__("Email Verification",true),"/emailVerification",array("class"=>"style30")) ?></div>
				</div>
				<div class="um_box_mid_content_mid_right" align="right">

				</div>
				<div style="clear:both"></div>
			</div>
		</div>
	</div>
	<div class="um_box_down"></div>
</div>-->
<script>
document.getElementById("UserEmail").focus();
</script>
