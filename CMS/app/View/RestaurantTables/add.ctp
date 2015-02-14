
<!--<h4 class="titel">Add a RestaurantTable </h4>-->       
<?php echo $this->Form->create('RestaurantTable', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="widget widget-blue">
          <div class="widget-title">
          <h3><i class="icon-ok-sign"></i> Add Table</h3>
          </div>
          <div class="widget-content">

    
 
    <div class="form-group">
        <label class="col-sm-4 control-label">Name :</label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('RestaurantTable.name', array('type' => 'text', 'class' => 'required form-control', 'label' => false, 'div' => false)); ?>
        </div>            
    </div>
        
        <div class="form-group">
        <label class="col-sm-4 control-label"></label>
        <div class="col-sm-8">   
             
            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-primary btn-success')); ?>               
            <?php echo $this->Html->link("Cancel", '/restaurantTables/index/' . $rid, array('escape' => false, 'tbtn-succesitle' => 'Cancel','class'=>'btn btn-danger'));?>
        </div>
    </div>
     </div>
        </div>
<?php echo $this->Form->end(); ?>

