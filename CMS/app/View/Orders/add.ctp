<script type="text/javascript">

    $(document).ready(function() {
//       $("#start_date").datepicker({
//            dateFormat: "yy/mm/dd",
//             });
//        $('#end_date').datepicker({
//            dateFormat: "yy/mm/dd",
//            
//        });
        $("#start_date").datepicker({
            dateFormat: "yy/mm/dd",
            defaultDate: "+1w",
            minDate:0,
            onClose: function(selectedDate) {
                $("#end_date").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#end_date").datepicker({
            dateFormat: "yy/mm/dd",
            defaultDate: "+1w",          
            onClose: function(selectedDate) {
                $("#start_date").datepicker("option", "maxDate", selectedDate);
            }
        });
        $('#ItemAddForm').submit(function() {
            if ($('#start_date').val() != '' || $('#end_date').val() != '') {
                if ($('#start_date').val() == '') {
                    alert('please fill start date');
                    $('#start_date').focus();
                    $('#start_date').attr('required', 'required');
                }
                if ($('#end_date').val() == '') {
                    alert('please fill end date');
                    $('#end_date').focus();
                    $('#end_date').attr('required', 'required');
                }
            }


        })
        var intId = 0;
        $("#add_item_choice").click(function() {
            var fieldWrapper = $("<div class=\"fieldwrapper file_inputwrapper  row\" id=\"field" + intId + "\"/>");
            //var fLabel = $("<label class=\"file_label\" id=\"label" + intId + "\">&nbsp;</label>");
            var fInput = $("<div class=\"col-md-3\" ><input placeholder=\"Item Name\" type=\"text\" id=\"ItemName" + intId + "\" class=\" form-control required \" name=\"data[ItemChoice][name][]\" /></div> <div class=\"col-md-3\" ><input placeholder=\"Item desc\" type=\"text\" id=\"ItemDescription" + intId + "\" class=\"form-control required \" name=\"data[ItemChoice][description][]\" /></div><div class=\"col-md-3\" ><input placeholder=\"Item price\" type=\"text\" id=\"ItemPrice" + intId + "\" class=\"form-control required \" name=\"data[ItemChoice][price][]\" /></div>");
            var removeButton = $("<div class=\"col-md-3\" ><input type=\"button\" class=\"remove_file btn btn-danger \"  onclick=\"$(this).closest('.fieldwrapper').remove();\" id=\"coun_btn\" value=\"X\" /></div>");

            fieldWrapper.append(fInput);
            fieldWrapper.append(removeButton);
            $("#input_file_tag").append(fieldWrapper);

           
            intId++;
        });


            
     
    });
/*This function is called when restaurant dropdown value change*/
function selecRestaurant(rest_id){
  if(rest_id!=""){
    loadData(rest_id);
  }
}

function loadData(restId){
  $.ajax({
     type: "POST",
    
     url:'<?php echo SITE_URL; ?>items/category_retaurant/',
     data: {rest_id:restId},
     cache: false,
     success: function(result){   

       $("#category_name").
      html("<option value=''></option>");
       $("#category_name").append(result);
       
     } , error: function(xhr, textStatus, error) {
                            alert(error);
                        }});              
}
</script>

<?php echo $this->Form->create('Item', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="widget widget-blue">
    <div class="widget-title">

        <h3><i class="icon-ok-sign"></i> Add Item</h3>
    </div>
    <div class="widget-content">

   <div class="form-group">
        <label class="col-sm-4 control-label">Restaurant Name :</label>
        <div class="col-sm-8">
             <?php echo $this->Form->input('Item.rest_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '','id'=>'restaurant_name', 'options' => $rest,'onchange'=>'selecRestaurant(this.options[this.selectedIndex].value)')); ?>                
        </div>            
    </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Category:</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.category_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => $ctys,'id'=>'category_name')); ?>                
            </div>
        </div>

        <!--        <div class="form-group">
                    <label class="col-sm-4 control-label">Restaurant Name:</label>
                    <div class="col-sm-8">
        <?php echo $this->Form->input('Item.rest_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => $rest)); ?>                
                    </div>
                </div>-->
        <div class="form-group">
            <label class="col-sm-4 control-label">Item Name :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.name', array('type' => 'text', 'class' => 'required form-control', 'label' => false, 'div' => false)); ?>
            </div>            
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Description :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.description', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'required form-control')); ?>

            </div>
        </div>      
        <div class="form-group">
            <label class="col-sm-4 control-label">Price:</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.price', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'required form-control')); ?>

            </div>
        </div> 
        <div class="form-group">
            <label class="col-sm-4 control-label">Start Date :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.start_date', array('type' => 'text', 'id' => 'start_date', 'label' => false, 'div' => false, 'class' => 'required datepicker form-control')); ?>

            </div>
        </div>  
        <div class="form-group">
            <label class="col-sm-4 control-label">End Date :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.end_date', array('type' => 'text', 'id' => 'end_date', 'label' => false, 'div' => false, 'class' => 'required datepicker form-control')); ?>

            </div>
        </div>  



        <div class="form-group multiple_file">
            <div id="input_file_tag" class="input file">
<!--              <label class="control-label">Add choice :</label>-->
            </div>
        </div>


       



        <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-8">   

            <?php echo $this->Form->button('Add item choice', array('type' => 'button', 'id' => 'add_item_choice', 'class' => 'btn btn-info btn_outer')); ?>                    

     
                <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'btnsubmit')); ?>              
                <?php echo $this->Html->link("Cancel", '/items', array('escape' => false, 'tbtn-succesitle' => 'Cancel', 'class' => 'btn btn-danger')); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>

