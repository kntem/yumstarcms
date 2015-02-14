
<!--<h4 class="titel">Add a Restaurant </h4>-->       
<?php echo $this->Form->create('Restaurant', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="widget widget-blue">
          <div class="widget-title">
          <h3><i class="icon-ok-sign"></i> Add Restaurant</h3>
          </div>
          <div class="widget-content">
<?php $user_type = $this->UserAuth->getUser();
        $user_type = $user_type['UserGroup']['name'];
        if($user_type == 'Admin'){?>
    
    <div class="form-group">
        <label class="col-sm-4 control-label">User Name :</label>
        <div class="col-sm-8">
             <?php echo $this->Form->input('Restaurant.user_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => $user)); ?>                
        </div>            
    </div>
        <?php }?>
    <div class="form-group">
        <label class="col-sm-4 control-label">Restaurant Name :</label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('Restaurant.name', array('type' => 'text', 'class' => 'required form-control', 'label' => false, 'div' => false)); ?>
        </div>            
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Address :</label>
        <div class="col-sm-8">
                 <?php echo $this->Form->input('Restaurant.address', array('type' => 'text','label' => false, 'div' => false, 'class' => 'required form-control')); ?>
          
        </div>
    </div>      
               <div class="form-group">
        <label class="col-sm-4 control-label">Area :</label>
        <div class="col-sm-8">
                 <?php echo $this->Form->input('Restaurant.area', array('type' => 'text','label' => false, 'div' => false, 'class' => 'required form-control')); ?>
          
        </div>
    </div>      
               <div class="form-group">
        <label class="col-sm-4 control-label">City :</label>
        <div class="col-sm-8">
                 <?php echo $this->Form->input('Restaurant.city', array('type' => 'text','label' => false, 'div' => false, 'class' => 'required form-control')); ?>
          
        </div>
    </div>      
               <div class="form-group">
        <label class="col-sm-4 control-label">Email :</label>
        <div class="col-sm-8">
                 <?php echo $this->Form->input('Restaurant.email', array('type' => 'email','label' => false, 'div' => false, 'class' => 'required form-control')); ?>
          
        </div>
    </div>      
               <div class="form-group">
        <label class="col-sm-4 control-label">Contact No :</label>
        <div class="col-sm-8">
                 <?php echo $this->Form->input('Restaurant.contact_no', array('type' => 'text','label' => false, 'div' => false, 'class' => 'required form-control')); ?>
          
        </div>
    </div>  
                  <div class="form-group">
        <label class="col-sm-4 control-label">Image :</label>
        <div class="col-sm-8">
                <?php echo $this->Form->input('Restaurant.image', array('class' => 'form-control', 'type' => 'file', 'label' => false, 'div' => false)); ?>
          
        </div>
    </div>  
        <div class="form-group">
        <label class="col-sm-4 control-label"></label>
        <div class="col-sm-8">   
             
            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-primary btn-success')); ?>               
            <?php echo $this->Html->link("Cancel", '/restaurants', array('escape' => false, 'tbtn-succesitle' => 'Cancel','class'=>'btn btn-danger'));?>
        </div>
    </div>
     </div>
        </div>
<?php echo $this->Form->end(); ?>

