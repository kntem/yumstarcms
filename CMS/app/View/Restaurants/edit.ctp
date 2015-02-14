



<?php echo $this->Form->create('Restaurant', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="widget widget-blue">
          <div class="widget-title">
          <h3><i class="icon-ok-sign"></i> Edit Restaurant</h3>
          </div>
          <div class="widget-content">
<?php $user_type = $this->UserAuth->getUser();
        $user_type = $user_type['UserGroup']['name'];
        if($user_type == 'Admin'){?>
    
    <div class="form-group">
        <label class="col-sm-4 control-label">User Name :</label>
        <div class="col-sm-8">
             <?php echo $this->Form->input('Restaurant.user_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => $user,'selected'=>$restaurant['Restaurant']['user_id'])); ?>                
        </div>            
    </div>
        <?php }?>
       <div class="form-group">
        <label class="col-sm-4 control-label">Name :</label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('Restaurant.name', array('type' => 'text', 'class' => 'required form-control', 'label' => false, 'div' => false,'value' => $restaurant['Restaurant']['name'])); ?>
        </div>            
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Address :</label>
        <div class="col-sm-8">
                 <?php echo $this->Form->input('Restaurant.address', array('type' => 'text','label' => false, 'div' => false, 'class' => 'required form-control','value' => $restaurant['Restaurant']['address'])); ?>
        </div>
    </div>      
     <div class="form-group">
        <label class="col-sm-4 control-label">Area :</label>
        <div class="col-sm-8">
             <?php echo $this->Form->input('Restaurant.area', array('type' => 'text','label' => false, 'div' => false, 'class' => 'required form-control','value' => $restaurant['Restaurant']['area'])); ?>
        </div>
    </div>   
              <div class="form-group">
        <label class="col-sm-4 control-label">City :</label>
        <div class="col-sm-8">
             <?php echo $this->Form->input('Restaurant.city', array('type' => 'text','label' => false, 'div' => false, 'class' => 'required form-control','value' => $restaurant['Restaurant']['city'])); ?>
        </div>
    </div>   
               <div class="form-group">
        <label class="col-sm-4 control-label">Email :</label>
        <div class="col-sm-8">
             <?php echo $this->Form->input('Restaurant.email', array('type' => 'email','label' => false, 'div' => false, 'class' => 'required form-control','value' => $restaurant['Restaurant']['email'])); ?>
        </div>
    </div>   
               <div class="form-group">
        <label class="col-sm-4 control-label">Contact No. :</label>
        <div class="col-sm-8">
             <?php echo $this->Form->input('Restaurant.contact_no', array('type' => 'text','label' => false, 'div' => false, 'class' => 'required form-control','value' => $restaurant['Restaurant']['contact_no'])); ?>
        </div>
    </div>  
                  <div class="form-group">
        <label class="col-sm-4 control-label">Image :</label>
        <div class="col-sm-8">
             <?php if($restaurant['Restaurant']['image'] == NULL)
             {
                                  echo 'No Image set in this Category';
             }
             else{
                   $icon_path = SITE_URL . "restaurant_images/" . $restaurant['Restaurant']['image'];
                                    echo $this->Html->link($this->Html->image($icon_path, array('width' => '150', 'height' => '150')), $icon_path, array('class' => 'fancybox', 'escape' => false, 'data-fancybox-group' => 'button'));
                 
             }
?>
                <?php echo $this->Form->input('Restaurant.image', array('class' => 'form-control', 'type' => 'file', 'label' => false, 'div' => false)); ?>
          
        </div>
    </div> 
    <div class="form-group">
        <label class="col-sm-4 control-label"></label>
        <div class="col-sm-8">   
            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-success')); ?>  
              <?php echo $this->Html->link("Cancel", '/restaurants', array('escape' => false, 'tbtn-succesitle' => 'Cancel','class'=>'btn btn-danger'));?>
        </div>
    </div>
     </div>
        </div>
<?php echo $this->Form->end(); ?>
