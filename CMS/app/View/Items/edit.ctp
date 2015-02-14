<script type="text/javascript">

    $(document).ready(function() {
        //for item_choice_lidting
        var options = {
            currPage: 1,
            optionsForRows: [15, 25],
            rowsPerPage: 5,
            topNav: false
        }
        $('#item_choice_list').tablePagination(options);
        $("#item_choice_list").tablesorter({headers: {0: {sorter: false}, 5: {sorter: false}}});


        // Select all item_choice
        $("#choice_select_all").change(function() {

            if ($(this).is(":checked")) {
                var val1 = 1;

            }
            else
            {
                var val1 = 0;

            }
            if (val1 == 1) {
                $(".choice_checkboxs").each(function() {
                    $(this).attr("checked", true);
                });
            }
            else if (val1 == 0) {
                $(".choice_checkboxs").each(function() {
                    $(this).removeAttr("checked");
                });
            }

        });

        //bulk delete item.        
        $("#choice_delete").click(function() {
            //get ticket ids from checked checkbox's id.
            var item_ids = jQuery('input.choice_checkboxs:checkbox:checked').map(function() {
                return this.id;
            }).get();
            //count how many records are selected
            var count = 0;
            $(".choice_checkboxs").each(function() {
                if ($(this).is(":checked"))
                {
                    count = count + 1;
                }
            });

            if (item_ids != '') {

                if (confirm('You are about to delete  ' + count + ' records are you sure?'))
                {
//                    alert(jQuery('#SITE_URL').val());
//               exit;

                    $.ajax({//fetch the article via ajax            
                        type: "POST",
                        url: '<?php echo SITE_URL; ?>items/choice_builk_delete', //calling this page
                        data: "choice_ids=" + item_ids,
                     
                        success: function(html) {
                            var response = $.parseJSON(html);
                            if (response.is_deleted == 1) {
                                jQuery('input.choice_checkboxs:checkbox:checked').parents("tr").remove();
//                                $('#ticket_list').tablePagination(options);
                            }
                            //jQuery("#indicator").hide();
                        }
                    });
                }
//                else{
//                alert('gfdf');
//                }

            }
            else
            {
                // if no checkboxes selected
                alert('Please select any item to delete ');
                return false;
            }
        });
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
            minDate: 0,
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

        // item_choice edit

        $('.confirm_edit').click(function() {
            var id = $(this).attr('id');
            if ($(this).text() === "Edit")
            {
                $('#row_' + id + ' .lblname_' + id).each(function() {
                    $(this).html('<input type="text"  class="inline_edit_name " data-item_choice_id1="' + id + '" id="name" value="' + $(this).html() + '" />');
                });
                $('#row_' + id + ' .lbldesc_' + id).each(function() {
                    $(this).html('<input type="text"  class="inline_edit_desc " data-item_choice_id2="' + id + '" id="desc" value="' + $(this).html() + '" />');
                });
                $('#row_' + id + ' .lblprice_' + id).each(function() {
                    $(this).html('<input type="text"  class="inline_edit_price " data-item_choice_id3="' + id + '" id="price" value="' + $(this).html() + '" />');
                });

                $(this).text('Save');
                $('#row_' + id + ' .text-right1').append('<a class="remove_inline_edit btn" data-id="' + id + '" >Cancel</a>');

            }
            else if ($(this).text() === "Save")
            {
                var value1 = $('[data-item_choice_id1="' + id + '"]').val();
                var value2 = $('[data-item_choice_id2="' + id + '"]').val();
                var value3 = $('[data-item_choice_id3="' + id + '"]').val();
                var data_item = [value1, value2, value3];
                save_choice(id, data_item)
//                $(this).text('Edit');

            }
            return false;
        });
        //use to save at whwn enter press

        $(".inline_edit").live('keypress', function(e) {

            if (e.which == 13) {
                var id = $(this).attr('data-item_choice_id');
                var value = $.trim($(this).val());
//                save_attachment(id, value);
            }
        });
        //use to remove text 
        var i = 0;
//        var val1=$(".lblname_" + id).text();
//        var val2=$(".lbldesc_" + id).text();
//        var val3=$(".lblprice_" + id).text();
//        $(document).live('click', ".remove_inline_edit", function() {
        $(".remove_inline_edit").live('click', function() {
            var id = $(this).attr('data-id');
            var value1 = $('[data-item_choice_id1="' + id + '"]').val();
            var value2 = $('[data-item_choice_id2="' + id + '"]').val();
            var value3 = $('[data-item_choice_id3="' + id + '"]').val();
            $(".inline_edit_name").remove();
            $(".inline_edit_desc").remove();
            $(".inline_edit_price").remove();
            $(".remove_inline_edit").remove();
            $(".lblname_" + id).text(value1);
            $(".lbldesc_" + id).text(value2);
            $(".lblprice_" + id).text(value3);
//            alert($(this).find("td a.confirm_edit").text());
            $('.confirm_edit').text('Edit');
        });
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
    function save_choice(id, data_item) {
        $.ajax({
            type: "POST",
            url: '<?php echo SITE_URL; ?>items/edit_item_choice/' + id,
            data: {id: id, data_item: data_item},
            success: function(data) {
                var obj = JSON.parse(data);

                $('#row_' + id + ' .lblname_' + id).each(function() {
                    $(this).replaceWith('<span class="lblname_'+id+'">'+obj.choice_name+'</span>');
                });
                $('#row_' + id + ' .lbldesc_' + id).each(function() {
                    $(this).replaceWith('<span class="lbldesc_'+id+'">'+obj.description+'</span>');
                });
                $('#row_' + id + ' .lblprice_' + id).each(function() {
                    $(this).replaceWith('<span class="lblprice_'+id+'">'+obj.price+'</span>');
                });
                $('.confirm_edit').text('Edit');
                $(".remove_inline_edit").remove();
//                alert("Record Updated successfully");

            },
            error: function(data) {
                alert("Error Updating");
            }
        });
    }
    /*This function is called when restaurant dropdown value change*/
    function selecRestaurant(rest_id) {
        if (rest_id != "") {
            loadData(rest_id);
        }
    }

    function loadData(restId) {
        $.ajax({
            type: "POST",
            url: '<?php echo SITE_URL; ?>items/category_retaurant/',
            data: {rest_id: restId},
            cache: false,
            success: function(result) {

                $("#category_name").
                        html("<option value=''></option>");
                $("#category_name").append(result);

            }, error: function(xhr, textStatus, error) {
                alert(error);
            }});
    }
    function selecCategory(parent_id){
  if(parent_id!=""){
    loadData1(parent_id);
  }
}

function loadData1(parentId){
  $.ajax({
     type: "POST",
    
     url:'<?php echo SITE_URL; ?>items/get_sub_category/',
     data: {parent_id:parentId},
     cache: false,
     success: function(result){   

        
            $("#sub_category_name").
            html("<option value=''></option>");
            $("#sub_category_name").append(result);
        }
       
     , error: function(xhr, textStatus, error) {
                            alert(error);
                        }});
                    }
</script>

<?php echo $this->Form->create('Item', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="widget widget-blue">
    <div class="widget-title">

        <h3><i class="icon-ok-sign"></i> Edit Item</h3>
    </div>
    <div class="widget-content">

 <?php if(!empty($options)){ 
        if($grp_id != 5) {
        ?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Restaurant Name:</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.rest_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'id' => 'restaurant_name', 'options' => $options, 'onchange' => 'selecRestaurant(this.options[this.selectedIndex].value)', 'selected' => $item['Item']['rest_id'],'required'=>true)); ?>                
            </div>
        </div><?php }} 
        if(!empty($ctys)) {?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Category:</label>
            <div class="col-sm-8">
                 <?php if($grp_id != 5) {
                echo $this->Form->input('Item.parent_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select','id'=>'category_name', 'empty' => '', 'options' =>$ctys,'onchange'=>'selecCategory(this.options[this.selectedIndex].value)','selected' => $item['Category']['parent_id'],'required'=>true));
                
            }else
            {
//                echo 'hii';
                echo $this->Form->input('Item.parent_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select','id'=>'category_name', 'empty' => '', 'options' => $ctys,'onchange'=>'selecCategory(this.options[this.selectedIndex].value)','selected' => $item['Category']['parent_id'],'required'=>true));
            }
?>        
                <?php // echo $this->Form->input('Item.category_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'id' => 'category_name', 'empty' => '', 'options' => $ctys, 'selected' => $item['Item']['category_id'])); ?>                
            </div>
        </div>
          <div class="form-group" id="child_cat">
        <label class="col-sm-4 control-label">Child Category:</label>
        <div class="col-sm-8">
            <?php if($grp_id != 5) {echo $this->Form->input('Item.category_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select','id'=>'sub_category_name', 'empty' => '', 'options' => $sub_cat, 'selected' => $item['Item']['category_id'],'required'=>true));}else
            {
                echo $this->Form->input('Item.category_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select','id'=>'sub_category_name', 'empty' => '', 'options' => $sub_cat,'selected' => $item['Item']['category_id'],'required'=>true));
            }
?>                
        </div>
    </div>
 <?php }?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Item Name :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.name', array('type' => 'text', 'class' => 'required form-control', 'label' => false, 'div' => false, 'value' => $item['Item']['name'])); ?>
            </div>            
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Description :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.description', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'required form-control', 'value' => $item['Item']['description'])); ?>

            </div>
        </div>      
        <div class="form-group">
            <label class="col-sm-4 control-label">Price :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Item.price', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'required form-control', 'value' => $item['Item']['price'])); ?>

            </div>
        </div>   
        <div class="form-group">
            <label class="col-sm-4 control-label">Start Date :</label>
            <div class="col-sm-8"><?php
                $date_range = '';
                if ($item['Item']['start_date'] != null) {
                    $date_range = $item['Item']['start_date'] . ' to ' . $item['Item']['end_date'];
                }
                ?>
<?php echo $this->Form->input('Item.date', array('type' => 'text', 'id' => 'date', 'label' => false, 'div' => false, 'class' => 'required input-daterangepicker form-control', 'value' => $date_range)); ?>

            </div>
        </div>  
        <!--        <div class="form-group">
                    <label class="col-sm-4 control-label">End Date :</label>
                    <div class="col-sm-8">
<?php echo $this->Form->input('Item.end_date', array('type' => 'text', 'id' => 'end_date', 'label' => false, 'div' => false, 'class' => 'required datepicker form-control', 'value' => $item['Item']['end_date'])); ?>
        
                    </div>
                </div> -->

        <div class="widget widget-blue">
            <div class="widget-title">

                <h3><i class="icon-table"></i> Item choices</h3>
            </div>
            <div class="widget-content">
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-sm-12 text-right">
<?php echo $this->Form->button('Add item choice', array('type' => 'button', 'id' => 'add_item_choice', 'class' => 'btn btn-info btn_outer')); ?>                    
<?php echo $this->Form->button('Delete Selected', array('type' => 'button','class' => 'btn btn-danger', 'id' => 'choice_delete'), __('are u delete?')); ?>
                        <!--<button type="button" class="btn btn-primary">Delete All Item</button>-->
                    </div>                    </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="item_choice_list">
                        <thead>
                            <tr>
                                <th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'choice_select_all')); ?></div></th>
                        <th>ID</th>
                        <th>Choice Name</th>
                        <th>Description</th>
                        <th>price</th>
                        <th></th>              
                        </tr>
                        </thead>
                        <tbody>
<?php if (!empty($item_choice)) { ?>
    <?php foreach ($item_choice as $item_choices) { ?>
                                    <tr id="row_<?php echo $item_choices['ItemChoice']['id']; ?>">

                                        <td><div class="checkbox"><?php echo $this->Form->checkbox('choice_id', array('id' => $item_choices['ItemChoice']['id'], 'class' => 'choice_checkboxs', 'hiddenField' => false)); ?></div></td>
                                        <td><?php echo $item_choices['ItemChoice']['id']; ?></td>
                                        <td><span class="lblname_<?php echo $item_choices['ItemChoice']['id'] ?>"><?php echo $item_choices['ItemChoice']['choice_name']; ?></span></td>
                                        <td><span class="lbldesc_<?php echo $item_choices['ItemChoice']['id'] ?>"><?php echo $item_choices['ItemChoice']['description']; ?></span></td>
                                        <td><span class="lblprice_<?php echo $item_choices['ItemChoice']['id'] ?>"><?php echo $item_choices['ItemChoice']['price']; ?></span></td>
                                        <td class="text-right">
                                            <span class="text-right1">
                                            <?php echo $this->Js->link("Edit", array('controller' => 'items', 'action' => 'editItemChoice', $item_choices['ItemChoice']['id']), array('escape' => false, 'class' => 'confirm_edit my', 'id' => $item_choices['ItemChoice']['id'])); ?>
                                            </span>
                                            <!--<a class="btn btn-default btn-xs" href="#">edit</a>-->
        <?php echo $this->Html->link("<i class='icon-remove'></i>", array('action' => 'deletechoice', $item_choices['ItemChoice']['id']), array('class' => 'btn btn-danger btn-xs ', 'escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $item_choices['ItemChoice']['choice_name'])); ?>
                                            <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr ><td colspan="6" style="text-align:center;"><?php echo "No Item Choices Available in this item."; ?></td></tr>
<?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="form-group multiple_file">
                    <div id="input_file_tag" class="input file">
                        <!--              <label class="control-label">Add choice :</label>-->
                    </div>
                </div>

            </div>

        </div>



        <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-8">   

<?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-success')); ?>    
<?php echo $this->Html->link("Cancel", '/items', array('escape' => false, 'tbtn-succesitle' => 'Cancel', 'class' => 'btn btn-danger')); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
 