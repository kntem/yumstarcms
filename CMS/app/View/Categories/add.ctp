<script type="text/javascript">
    function validateForm(){        
            var is_validate = false;
            var name1 = $('#CategoryName').val();
            var restid = $('#restaurant_name').val();
            $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>categories/validate_cat_name',
                data: {name: name1, rest_id: restid},
                cache: false,
                async: false,
                success: function(result) {                
                    if (result == 'please add another category name') {
                              $('#errmsg').text(result);
                    $('#errmsg').show();
//                    $('#CategoryName').val("").focus();
//      $('#nm').replaceWith(result);
//                    var textarea = $('form#validateForm input#CategoryName');
//                    var tmpStr = textarea.val();
//                    textarea.val('');
//                    textarea.val('').focus();                   
                    } else {                      
                         //$('#validateForm').submit();
                        is_validate = true;
                    }
                }, error: function(xhr, textStatus, error) {
                    alert(error);
                }});
                return is_validate;
// return false;        
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
            url: '<?php echo SITE_URL; ?>categories/category_retaurant/1',
            data: {rest_id: restId},
            cache: false,
            success: function(result) {
                if (result == 'no data') {
                    $("#par_cat").hide();
                    $("#category_name").removeAttr("required");
                } else {
                    $("#par_cat").show();

                    $("#category_name").
                            html("<option value=''></option>");
                    $("#category_name").append(result);
                }
            }, error: function(xhr, textStatus, error) {
                alert(error);
            }});
    }
    function validationcategory(data) {
        var value1 = data;
        if (value1 == 0) {
//      $('#par_cat').hide();
            $('#catname').text('Parent Category Name :');
        }
        else {
//       $('#par_cat').show();
            $('#catname').text('Sub Category Name :');
        }
    }
    function validation_category_name(name1) {
//    alert(name1);
        var restid = $('#restaurant_name').val();
//   alert(restid);
// var name = document.getElementById("catname").val();
// alert(name);
        $.ajax({
            type: "POST",
            url: '<?php echo SITE_URL; ?>categories/validate_cat_name',
            data: {name: name1, rest_id: restid},
            cache: false,
            success: function(result) {

                if (result == 'please add another category name') {
                    $('#errmsg').text(result);
                    $('#errmsg').show();
//                    $('#CategoryName').val("").focus();
//      $('#nm').replaceWith(result);
                    var textarea = $('form#validateForm input#CategoryName');
                    var tmpStr = textarea.val();
                    textarea.val('');
                    textarea.val(tmpStr).focus();

                }
                else {
                    $('#errmsg').hide();

                }
            }, error: function(xhr, textStatus, error) {
                alert(error);
            }});
    }

</script>



<?php echo $this->Form->create('Category', array('class' => 'form-horizontal', 'type' => 'file', 'id' => 'validateForm','onSubmit'=>'return validateForm();')); ?>
<div class="widget widget-blue">
    <div class="widget-title">

        <h3><i class="icon-ok-sign"></i> Add Category</h3>
    </div>
    <div class="widget-content">


        <?php
        if (!empty($restaurant)) {
            if ($grp_id != 5) {
                ?>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Restaurant Name :</label>
                    <div class="col-sm-8">
                        <?php echo $this->Form->input('Category.rest_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'id' => 'restaurant_name', 'options' => $restaurant, 'onchange' => 'selecRestaurant(this.options[this.selectedIndex].value)', 'required' => true)); ?>                
                    </div>            
                </div>
                <?php
            }
        }
        if (!empty($ctys)) {
            ?>
            <div class="form-group" id="par_cat">
                <label class="col-sm-4 control-label">Parent Category:</label>
                <div class="col-sm-8">
                    <?php
                    if ($grp_id != 5) {
                        echo $this->Form->input('Category.parent_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'id' => 'category_name', 'empty' => '', 'options' => '', 'onchange' => 'validationcategory(this.options[this.selectedIndex].value)'));
                    } else {

                        echo $this->Form->input('Category.parent_id', array('class' => 'required form-control', 'label' => false, 'type' => 'select', 'id' => 'category_name', 'empty' => '', 'options' => $ctys, 'onchange' => 'validationcategory(this.options[this.selectedIndex].value)'));
                    }
                    ?>             
                </div>
            </div><?php } ?>

        <div class="form-group" id='name'>
            <label class="col-sm-4 control-label" id="catname">Category Name :</label>
            <div class="col-sm-8">
                <?php // echo $this->Form->input('Category.name', array('id'=>'catname','type' => 'text', 'class' => 'required form-control', 'label' => false, 'div' => false,'required'=>true));  ?>
                <?php echo $this->Form->input('Category.name', array('type' => 'text', 'class' => 'required form-control', 'label' => false, 'div' => false, 'required' => true, 'onblur' => 'validation_category_name(this.value)')); ?>
            </div>

            <div id='errmsg' style='display:none;text-align:center;' class='col-sm-12'></div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Description :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Category.description', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'required form-control')); ?>

            </div>
        </div>      
        <div class="form-group">
            <label class="col-sm-4 control-label">Icon :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('Category.icon', array('class' => 'form-control', 'type' => 'file', 'label' => false, 'div' => false)); ?>

            </div>
        </div>   
        <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-8">   
                <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-success')); ?>       
                <?php echo $this->Html->link("Cancel", '/categories', array('escape' => false, 'tbtn-succesitle' => 'Cancel', 'class' => 'btn btn-danger')); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>

