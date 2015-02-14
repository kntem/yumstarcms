<script type="text/javascript">
    $(document).ready(function() {
//
//        $("#userSetting_select_all").click(function() {
//        
//            if ($(this).is(":checked")) {
//                $(".userSetting_checkboxs").each(function() {
//                    $(this).prop("checked", true);
//                });
//            }
//            else
//            {
//                $(".userSetting_checkboxs").each(function() {
//                    $(this).removeProp("checked");
//                });
//            }
//        });
   var options = {
            currPage: 1,
            optionsForRows: [15, 25],
            rowsPerPage: 5,
            topNav: false
        }
//        $('#userSetting_list').tablePagination(options);
        $("#userSetting_list").tablesorter({headers: {0: {sorter: false},4: {sorter: false}}});
        $("#userSetting_select_all").change(function() {        
            if ($(this).is(":checked")) {
                var val1 = 1;               
            }
            else
            {
                var val1 = 0;               
            }
            if(val1 == 1){
                 $(".userSetting_checkboxs").each(function() {
                    $(this).attr("checked", true);
                });
            }
            else if(val1 == 0){
                 $(".userSetting_checkboxs").each(function() {
                    $(this).removeAttr("checked");
                });
            }            
        });
            //bulk delete userSetting.        
        $("#userSetting_delete").click(function() {
            //get ticket ids from checked checkbox's id.
            var userSetting_ids = jQuery('input.userSetting_checkboxs:checkbox:checked').map(function() {
                return this.id;
            }).get();
            //count how many records are selected
            var count = 0;
            $(".userSetting_checkboxs").each(function() {
                if ($(this).is(":checked"))
                {
                    count = count + 1;
                }
            });

            if (userSetting_ids != '') {
               
                if (confirm('You are about to delete  ' + count + ' records are you sure?'))
                { 
//                    alert(jQuery('#SITE_URL').val());


                    $.ajax({//fetch the article via ajax            
                        type: "POST",
                        url: 'userSettings/userSetting_builk_delete', //calling this page
                        data: "userSetting_ids=" + userSetting_ids,
                        beforeSend: function() {
                            //jQuery("#indicator").show();
                        },
                        success: function(html) {
                            var response = $.parseJSON(html);
                            if (response.is_deleted == 1) {
                                jQuery('input.userSetting_checkboxs:checkbox:checked').parents("tr").remove();
//                                $('#ticket_list').tablePagination(options);
                            }
                            //jQuery("#indicator").hide();
                        }
                    });
                }

            }
            else
            {
                // if no checkboxes selected
                alert('Please select any userSetting to delete ');
            }
        });
        
        $('.edit_setting').click(function() {
//        alert('hii');

            var id = $(this).attr('id');
            if ($(this).text() === "Setting")
            {
               
//            console.log('2nd');
                $('#row_' + id + ' .lbl_' + id).each(function() {
                    
//                   console.log((this).val());
                    $(this).html('<input type="text"  class="inline_edit_name " data-item_choice_id1="' + id + '" id="name" value="' + $(this).html() + '" />');
                });
               
                $(this).text('Save');
                $('#row_' + id +' .text-right1').append('<a class="remove_inline_edit btn btn-default btn-xs" data-id="' + id + '" >Cancel</a>');
                

            }
            else if ($(this).text() === "Save")
            {
                var value1 = $('[data-item_choice_id1="' + id + '"]').val();              
                var data_item = value1;
                save_choice(id, data_item)
//                $(this).text('Edit');

            }
            return false;
        });
         $(".remove_inline_edit").live('click', function() {
            var id = $(this).attr('data-id');
            var value1 = $('[data-item_choice_id1="' + id + '"]').val();
            
            $(".inline_edit_name").remove();
          
            $(".remove_inline_edit").remove();
            $(".lbl_" + id).text(value1);          
//            alert($(this).find("td a.confirm_edit").text());
            $('.edit_setting').text('Setting');
        });
//            $(".remove_inline_edit").live('click', function() {
//            var id = $(this).attr('data-id');
//            var value1 = $('[data-item_choice_id1="' + id + '"]').val();
//            var value2 = $('[data-item_choice_id2="' + id + '"]').val();
//            var value3 = $('[data-item_choice_id3="' + id + '"]').val();
//            $(".inline_edit_name").remove();
//            $(".inline_edit_desc").remove();
//            $(".inline_edit_price").remove();
//            $(".remove_inline_edit").remove();
//            $(".lblname_" + id).text(value1);
//            $(".lbldesc_" + id).text(value2);
//            $(".lblprice_" + id).text(value3);
////            alert($(this).find("td a.confirm_edit").text());
//            $('.confirm_edit').text('Edit');
//        });
    });
        function save_choice(id, data_item) {
        $.ajax({
            type: "POST",
            url: '<?php echo SITE_URL; ?>userSettings/setting/' + id,
            data: {id: id, data_item: data_item},
            success: function(data) {
                var obj = JSON.parse(data);

                $('#row_' + id + ' .lbl_' + id).each(function() {
                    $(this).replaceWith('<span class="lbl_'+id+'">'+obj.bill_rate+'</span>');
                });
              $('.edit_setting').text('Setting');
                $(".remove_inline_edit").remove();
//                alert("Record Updated successfully");

            },
            error: function(data) {
                alert("Error Updating");
            }
        });
    }
</script>
 
      
      <div style="margin-bottom: 20px;">
             <?php echo $this->Form->create('Search', array('class' => 'form-inline ', 'id' => 'userSetting_search')); ?>
             <div class="row">
        <div class="col-sm-12">
                              <div class="form-group">                               
                                  <?php echo $this->Form->input('Search.name', array('type' => 'text', 'class' => 'form-control', 'label' => false,'placeholder'=>'User Name')); ?>    
                              </div>
                                <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success','id'=>'search')); ?>
                              <!--<button class="btn btn-primary" type="submit">Sign in</button>-->
                               <?php 
                                if(isset($flag)) {
         if($flag=='true') {
  
                                echo $this->Html->link('View All', '/userSettings', array('class' => 'btn btn-primary')); 
                                }}
                                echo $this->Form->end();
                                ?>  
        </div></div>
             </div>
<div class="clearfix"></div>
<div class="widget widget-blue">
      <div class="widget-title">
           
        <h3><i class="icon-table"></i>Settings</h3>
      </div>
      <div class="widget-content">
        <div class="table-responsive">
        <table class="table table-bordered table-hover" id="userSetting_list">
          <thead>
            <tr>
              <!--<th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'userSetting_select_all')); ?></div></th>-->
              <th>ID</th>
              <th>User Name</th>
              <th>Billing Rate(%)</th>
              <th></th>
                  
              
            </tr>
          </thead>
          <tbody>
               <?php
              
        if (!empty($users)) {          
            foreach ($users as $user) {               
                
                               ?>
            <tr id="row_<?php echo $user['User']['id']; ?>">
              <!--<td><div class="checkbox"><?php echo $this->Form->checkbox('userSetting_id', array('id' => $user['User']['id'], 'class' => 'user_checkboxs', 'hiddenField' => false)); ?></div></td>-->
              <td><?php echo $user['User']['id']; ?></td>              
              <td><?php echo $user['User']['username']; ?></td>   
              <td><span class="lbl_<?php echo $user['User']['id'] ?>"><?php   foreach ($userSettings as $userSetting) {
                  if($userSetting['UserSetting']['user_id'] == $user['User']['id'] ){
                  echo  $userSetting['UserSetting']['bill_rate'];               
                  
              } }
?></span></td>
              <td class="text-right">
                      <span class="text-right1">
                <?php echo $this->Js->link("Setting", array('controller' => 'UserSettings', 'action' => 'setting', $user['User']['id']), array('escape' => false, 'title' => 'Setting','class'=>'btn btn-default btn-xs edit_setting','id'=>$user['User']['id']));?>
                      </span>
              </td>
            </tr>
                 <?php }} else{
            ?> <tr><td colspan="4" class="fc-header-center">No Data Found</td></tr><?php
        }
        ?>
          </tbody>
        </table>
            
        </div>
      </div>
      <div class="pagination_outer pagination pagination-right pagination-mini" id="tablePagination">
        <span id="tablePagination_perPage"><?php
            if (isset($this->params->query['limit'])) {
                $limit = $this->params->query['limit'];
//            echo "Limit : ".$limit;
            } else {
                $limit = 5;
            }
            $options = array('5' => 5, '10' => 10, '20' => 20);

            echo $this->Form->create(array('type' => 'get'));

            echo $this->Form->select('limit', $options, array(
                'value' => $limit,
                'default' => $limit,
                'onChange' => 'this.form.submit();',
                'name' => 'limit',
                'id' => 'tablePagination_rowsPerPage',
                'class' => 'per_page span2'
                    )
            );
            echo $this->Form->end();
            ?>
            <span class="per_page">per page</span>                    
        </span>
        <ul id="tablePagination_paginater">                    
            <li>  <?php echo $this->paginator->first('|< first'); ?> </li>
            <li>  <?php echo $this->paginator->prev('<< prev', null, null, array('class' => 'prev disabled')); ?> </li>
            <li>   <?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a', 'escape' => false)); ?> </li>
            <li>   <?php echo $this->paginator->next('next >>', null, null, array('class' => 'next disabled')); ?> </li>
            <li>  <?php echo $this->paginator->last('last >|'); ?> </li>
            <li class="no_of_page"><?php echo $this->Paginator->counter(); ?></li>
               
        </ul>
    </div>
    </div>
  