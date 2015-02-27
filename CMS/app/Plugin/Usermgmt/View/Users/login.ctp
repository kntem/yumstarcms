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

<div id="container">
<?php echo $this->Form->create('User', array('action' => 'login')); ?>
<div class="all-wrapper no-menu-wrapper light-bg">
  <div class="login-logo-w">
    <a href="index.html" class="logo">
      <i class="icon-rocket"></i>
    </a>
  </div>
  <div class="row">
    <div class="col-md-4 col-md-offset-4">

      <div class="widget widget-blue">
        <div class="widget-title">
          <h3 class="text-center"><i class="icon-lock"></i> Login </h3>

        </div>
        <div class="widget-content">
            <?php echo $this->Session->flash(); ?>

          <form action="#" role="form">
              <div class="lined-separator"> login using email</div>
            <div class="form-group relative-w">
                <?php echo $this->Form->input("email" ,array('label' => false,'div' => false,'class'=>"form-control" ))?>
              <!--<input type="email" class="form-control" placeholder="Enter email">-->
              <i class="icon-user input-abs-icon"></i>
            </div>
            <div class="form-group relative-w">
                <?php echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"form-control" ))?>
              <!--<input type="password" class="form-control" placeholder="Password">-->
              <i class="icon-lock input-abs-icon"></i>
            </div>
               <div class="form-group relative-w">
            <?php
                $options = array( array('name' => 'Admin', 'value' => '1'),
                                array('name' => 'Buisness Owner', 'value' => '4'),
                                array('name' => 'Barristas/Cooks', 'value' => '5'),
                                 );
                echo $this->Form->input('user_type', array( 'type' => 'select',
                                                            'options' => $options,
                                                            'class' => 'form-control',
                                                            'label'=>FALSE));
            ?>
                 <?php //  echo $this->Form->select('field', array("Admin","Buisness Owner","Bar/cuisine Owner","class"=>"form-control")); ?>
                <?php // echo $this->Form->input("password" ,array("type"=>"password",'label' => false,'div' => false,'class'=>"form-control" ))?>
              <!--<input type="password" class="form-control" placeholder="Password">-->
              <!--<i class="icon-lock input-abs-icon"></i>-->
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <?php echo $this->Form->input("remember" ,array("type"=>"checkbox"));?>
                </label>
              </div>
            </div>
<!--
            <a href="index.html" class="btn btn-primary btn-rounded btn-iconed">
              <span>Log me in</span>-->
              <?php echo $this->Form->Submit(__('Log me in'),array('class'=>'btn btn-primary btn-rounded btn-iconed icon-arrow-right'));?>
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
