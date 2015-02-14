<script type="text/javascript">
    $(document).ready(function() {
//
//        $("#orderItem_select_all").click(function() {
//        
//            if ($(this).is(":checked")) {
//                $(".orderItem_checkboxs").each(function() {
//                    $(this).prop("checked", true);
//                });
//            }
//            else
//            {
//                $(".orderItem_checkboxs").each(function() {
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
        $('#orderItem_list').tablePagination(options);
        $("#orderItem_list").tablesorter({headers: {0: {sorter: false},7: {sorter: false},6: {sorter: false},9: {sorter: false},10: {sorter: false}}});
        $("#orderItem_select_all").change(function() {

            if ($(this).is(":checked")) {
                var val1 = 1;

            }
            else
            {
                var val1 = 0;

            }
            if (val1 == 1) {
                $(".orderItem_checkboxs").each(function() {
                    $(this).attr("checked", true);
                });
            }
            else if (val1 == 0) {
                $(".orderItem_checkboxs").each(function() {
                    $(this).removeAttr("checked");
                });
            }

        });
        //bulk delete orderItem.        
        $("#orderItem_delete").click(function() {
            //get ticket ids from checked checkbox's id.
            var orderItem_ids = jQuery('input.orderItem_checkboxs:checkbox:checked').map(function() {
                return this.id;
            }).get();
            //count how many records are selected
            var count = 0;
            $(".orderItem_checkboxs").each(function() {
                if ($(this).is(":checked"))
                {
                    count = count + 1;
                }
            });

            if (orderItem_ids != '') {

                if (confirm('You are about to delete  ' + count + ' records are you sure?'))
                {
//                    alert(jQuery('#SITE_URL').val());


                    $.ajax({//fetch the article via ajax            
                        type: "POST",
                        url: '<?php echo SITE_URL ?>orderItems/orderItem_builk_delete', //calling this page
                        data: "orderItem_ids=" + orderItem_ids,
                        beforeSend: function() {
                            //jQuery("#indicator").show();
                        },
                        success: function(html) {
                            var response = $.parseJSON(html);
                            if (response.is_deleted == 1) {
                                jQuery('input.orderItem_checkboxs:checkbox:checked').parents("tr").remove();
var rowCount = $('#orderItem_list tr').length;                              
                               if(rowCount == 1){                                
                              $('#orderItem_list > tbody:last').append('<tr><td colspan="11" class="fc-header-center">No Data found</td></tr>');
                               }
                            }
                            //jQuery("#indicator").hide();
                        }
                    });
                }

            }
            else
            {
                // if no checkboxes selected
                alert('Please select any orderItem to delete ');
            }
        });

    });
</script>


<div style="margin-bottom: 20px;">
    <?php // echo $this->Form->create('Search', array('class' => 'form-inline row', 'id' => 'orderItem_search', 'style' => 'float:left')); ?>
    <div class="form-group">                               
        <?php // echo $this->Form->input('Search.name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    
    </div>    
    <span class="input-group-btn">
        <?php echo $this->Form->button('cancel Selected', array('class' => 'btn btn-danger', 'style' => 'float:right', 'id' => 'orderItem_delete'), __('are u delete?')); ?>
      
    </span>
</div>
<div class="widget widget-blue">
    <div class="widget-title">

        <h3><i class="icon-table"></i> OrderItems</h3>
    </div>
    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="orderItem_list">
                <thead>
                    <tr>
                        <th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'orderItem_select_all')); ?></div></th>
                <th>ID</th>
                <th>Table Name</th>
                <th>Item Name</th>
                <th>Item Category</th>
                <th>Quantity</th>
                <th>Item Choice</th>                              
                <th>Comment</th>
                <th>Time</th>              
                <th></th>
                <th></th>
                </tr>
                </thead>
                <tbody>
                     <?php echo $this->Form->create('Search', array('class' => 'form-inline row', 'id' => 'order_item_search')); ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><?php echo $this->Form->input('Search.table_name', array('id'=>'table_name','class' => 'form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => $tables));
//                        echo $this->Form->input('Search.table_name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?></td>
                        <td><?php echo $this->Form->input('Search.item_name', array('id'=>'item_name','class' => 'form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => $items)); ?>                 
                            <?php // echo $this->Form->input('Search.item_name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    </td>
                        <td> <?php echo $this->Form->input('Search.category_name', array('id'=>'category_name','class' => 'form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => $categories));
//                        echo $this->Form->input('Search.category_name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    </td>
                        <td>  </td>
                        <td> <?php // echo $this->Form->input('Search.item_choice', array('id' => 'order_date', 'type' => 'text', 'class' => 'form-control datepicker', 'label' => false)); ?>    </td>
                        <td></td>
                        <td></td>
                     
                     
                        <td colspan="2" style="text-align:center;"> <?php
                            echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'search'));
                            if (isset($flag)) {
                                if ($flag == 'true') {
                                    echo $this->Html->link('View All', '/orderItems/running_item_index/', array('class' => 'btn btn-primary'));
                                }
                            }
                            ?>   </td>
                    </tr>
                    <?php echo $this->Form->end(); ?>  
                    <?php
//                    pr($orderItems);
//                   exit();
                    if (!empty($orderItems)) {
                        foreach ($orderItems as $orderItem) {
                            $item_id = $orderItem['OrderItem']['item_id'];
//                            App::import("Controller", "Categories");  // load model category
//                            $Category = new CategoriesController();
//                            $Category_list = $Category->get_category($item_id); // here check_if_holiday is a method inside PublicHoliday Model
                            ?>
                            <tr>
                                <td><div class="checkbox"><?php echo $this->Form->checkbox('orderItem_id', array('id' => $orderItem['OrderItem']['id'], 'class' => 'orderItem_checkboxs', 'hiddenField' => false)); ?></div></td>
                                <td><?php echo $orderItem['OrderItem']['id']; ?></td>     
                                <td><?php echo $orderItem['RestaurantTable']['name']; ?></td>     
                                <td><?php echo $orderItem['Item']['name']; ?></td>
                                <td><?php echo $orderItem['Category']['name']; ?></td>
                                <td><?php echo $orderItem['OrderItem']['quantity']; ?></td>
                                <td><?php
                                    if ($orderItem['OrderItem']['item_choice_id'] == -1) {
                                        echo "-";
                                    } else {
                                        echo $orderItem['ItemChoice']['choice_name'];
                                    }
                                    ?></td>                                                              
                                <td><?php echo $orderItem['OrderItem']['comment']; ?></td>
                                <td>  <?php 
                                $date = $orderItem['Order']['order_date'] ;   
                                 echo $time = date('H:i:s' , strtotime($date));
                                    ?></td>
                               <td>   <?php $cn='my';
                                    if ($orderItem['OrderItem']['status'] == 1) {
                                        $st = '2';
                                        echo $this->Html->link("Completed", array('action' => 'change_status', $orderItem['OrderItem']['id'],$st,$cn), array('class' => 'btn btn-warning btn-xs ', 'escape' => false, 'title' => 'Active'), __('Are you sure you want to complete # %s this orderItem?', $orderItem['OrderItem']['id']));
                                    }
                                    ?>   </td> <td> <?php
                                    if ($orderItem['OrderItem']['status'] == 1) {
                                        $st = '0';
                                        
                                        echo $this->Html->link("<i class='icon-remove'></i>", array('action' => 'change_status', $orderItem['OrderItem']['id'],$st,$cn), array('class' => 'btn btn-danger btn-xs ', 'escape' => false, 'title' => 'Active'), __('Are you sure you want to Cancel # %s this orderItem?', $orderItem['OrderItem']['id']));
                                    }
                                    ?></td>
                               <!--<td><span class="label label-success">Active</span></td>-->
                                <!--<td class="text-right">-->
                                    <?php // echo $this->Html->link("Edit", '/orderItems/edit/' . $orderItem['OrderItem']['id'], array('escape' => false, 'title' => 'Edit', 'class' => 'btn btn-default btn-xs'));   ?>
                                    <!--<a class="btn btn-default btn-xs" href="#">edit</a>-->
                                    <?php // echo $this->Form->postLink("<i class='icon-remove'></i>", array('action' => 'delete', $orderItem['OrderItem']['id']), array('class' => 'btn btn-danger btn-xs remove-tr', 'escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $orderItem['OrderItem']['id']));  ?>
                                    <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
                                <!--</td>-->
                            </tr>
                            <?php
                        }
                    }else {
                    ?>
                    <tr> <td colspan="11" style="text-align:center">No Record Found</td></tr><?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
