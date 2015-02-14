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
        $('#UserSettingAddForm').submit(function() {
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
        $("#add_userSetting_choice").click(function() {
            var fieldWrapper = $("<div class=\"fieldwrapper file_inputwrapper  row\" id=\"field" + intId + "\"/>");
            //var fLabel = $("<label class=\"file_label\" id=\"label" + intId + "\">&nbsp;</label>");
            var fInput = $("<div class=\"col-md-3\" ><input placeholder=\"UserSetting Name\" type=\"text\" id=\"UserSettingName" + intId + "\" class=\" form-control required \" name=\"data[UserSettingChoice][name][]\" /></div> <div class=\"col-md-3\" ><input placeholder=\"UserSetting desc\" type=\"text\" id=\"UserSettingDescription" + intId + "\" class=\"form-control required \" name=\"data[UserSettingChoice][description][]\" /></div><div class=\"col-md-3\" ><input placeholder=\"UserSetting price\" type=\"text\" id=\"UserSettingPrice" + intId + "\" class=\"form-control required \" name=\"data[UserSettingChoice][price][]\" /></div>");
            var removeButton = $("<div class=\"col-md-3\" ><input type=\"button\" class=\"remove_file btn btn-danger \"  onclick=\"$(this).closest('.fieldwrapper').remove();\" id=\"coun_btn\" value=\"X\" /></div>");

            fieldWrapper.append(fInput);
            fieldWrapper.append(removeButton);
            $("#input_file_tag").append(fieldWrapper);


            intId++;
        });




    });
    /*This function is called when restaurant dropdown value change*/
    function selecRestaurant(rest_id) {
        if (rest_id != "") {
            loadData(rest_id);
        }
    }

    function loadData(restId) {
        $.ajax({
            type: "POST",
            url: '<?php echo SITE_URL; ?>userSettings/category_retaurant/',
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
</script>

<?php echo $this->Form->create('UserSetting', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div class="widget widget-blue">
    <div class="widget-title">
<?php if(isset($rate)){
    $rat=$rate['UserSetting']['bill_rate'];} else{
        $rat='';
    }?>
        <h3><i class="icon-ok-sign"></i>Setting</h3>
    </div>
    <div class="widget-content">
        <div class="form-group">
            <label class="col-sm-4 control-label">Billing Rate(%) :</label>
            <div class="col-sm-8">
                <?php echo $this->Form->input('UserSetting.bill_rate', array('type' => 'text', 'class' => 'required form-control', 'label' => false, 'div' => false,'value'=> $rat)) ?>
            </div>            
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-8">   
                <?php echo $this->Form->button('Save Setting', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'btnsubmit')); ?>              
                <?php echo $this->Html->link("Cancel", '/userSettings', array('escape' => false, 'tbtn-succesitle' => 'Cancel', 'class' => 'btn btn-danger')); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>

