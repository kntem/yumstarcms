        <script type="text/javascript">

/*This function is called when restaurant dropdown value change*/
function selecRestaurant(rest_id){
  if(rest_id!=""){
    loadData(rest_id);
  }
}

function loadData(restId){
   var cat=$("#cat_id").val();

  $.ajax({
     type: "POST",
    
     url:'<?php echo SITE_URL; ?>categories/category_retaurant/',
     data: {rest_id:restId,cat_id:cat},
     cache: false,
     success: function(result){   
if(result == 'no data'){
    $("#par_cat").hide();
     $("#category_name").removeAttr("required");
}else{
    $("#par_cat").show();
       $("#category_name").
      html("<option value=''></option>");
       $("#category_name").append(result);
}
     } , error: function(xhr, textStatus, error) {
                            alert(error);
                        }});              
}
</script>

  
     
<?php echo $this->Form->create('Category', array('class' => 'form-horizontal', 'type' => 'file'));
echo $this->Form->hidden('cat_id', array('value' => $category['Category']['id'], 'id' => 'cat_id'));

?>
<?php // echo $this->Form->input(array('id' => $item['Item']['id'],'hiddenField' => true)); ?>
<div class="widget widget-blue">
          <div class="widget-title">
            
            <h3><i class="icon-ok-sign"></i> Edit Category</h3>
          </div>
          <div class="widget-content">
                <?php if(!empty($restaurant)){ 
        if($grp_id != 5) {
        ?>
 <div class="form-group">
        <label class="col-sm-4 control-label">Restaurant Name :</label>
        <div class="col-sm-8">
             <?php echo $this->Form->input('Category.rest_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => $restaurant,'id'=>'restaurant_name','selected' => $category['Category']['rest_id'],'onchange'=>'selecRestaurant(this.options[this.selectedIndex].value)','required'=>TRUE)); ?>                
        </div>            
    </div>
     <?php } }
    if(!empty($ctys)) {
        ?>
    <div class="form-group" id="par_cat">
        <label class="col-sm-4 control-label">Parent Category:</label>
        <div class="col-sm-8">
            <?php if($category['Category']['parent_id']==0){?>
            <div class="form-control">this is parent category so, no parent category available in this category</div>
           
            
           <?php }
                if($grp_id != 5) 
                {echo $this->Form->input('Category.parent_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => $ctys,'selected' => $category['Category']['parent_id'],'id'=>'category_name')); 
             }else
            {                
               echo $this->Form->input('Category.parent_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select','id'=>'category_name', 'empty' => '', 'options' => $ctys,'required'=>true,'selected' => $category['Category']['parent_id']));
           }?>                
        </div>
    </div><?php } ?>
    <div class="form-group">
        <label class="col-sm-4 control-label">Category Name :</label>
        <div class="col-sm-8">
            <?php echo $this->Form->input('Category.name', array('type' => 'text', 'class' => 'required form-control', 'label' => false, 'div' => false,'value' => $category['Category']['name'],'required'=>true)); ?>
        </div>            
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">Description :</label>
        <div class="col-sm-8">
                 <?php echo $this->Form->input('Category.description', array('type' => 'text','label' => false, 'div' => false, 'class' => 'required form-control','value' => $category['Category']['description'])); ?>
          
        </div>
    </div>      
     <div class="form-group">
        <label class="col-sm-4 control-label">Icon :</label>
        <div class="col-sm-8">
            
             <?php if($category['Category']['icon'] == ''){echo 'No Image set in this Category';}
             else{
                                    $icon_path = SITE_URL . "category_images/" . $category['Category']['icon'];
                                    echo $this->Html->link($this->Html->image($icon_path, array('width' => '150', 'height' => '150')), $icon_path, array('class' => 'fancybox', 'escape' => false, 'data-fancybox-group' => 'button'));
             }                    ?>
                <?php echo $this->Form->input('Category.icon', array('class' => 'form-control', 'type' => 'file', 'label' => false, 'div' => false)); ?>
          
        </div>
    </div>   
    <div class="form-group">
        <label class="col-sm-4 control-label"></label>
        <div class="col-sm-8">   
            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-success')); ?>        
            <?php echo $this->Html->link("Cancel", '/categories', array('escape' => false, 'tbtn-succesitle' => 'Cancel','class'=>'btn btn-danger'));?>
        </div>
    </div>
     </div>
        </div>
<?php echo $this->Form->end(); ?>
