<script type="text/javascript">
    $(document).ready(function() {
//        $(".datepicker").datepicker({
//            dateFormat: "yy-mm-dd",
//            //defaultDate: "+1w",
//            changeMonth: true,
//            //numberOfMonths: 3,
//
//        });
        var options = {
            currPage: 1,
            optionsForRows: [15, 25],
            rowsPerPage: 5,
            topNav: false
        }
//          $("#order_from_date").datepicker({
//            dateFormat: "yy-mm-dd",
//            defaultDate: "+1w",
//            minDate:0,
//            onClose: function(selectedDate) {
//                $("#order_to_date").datepicker("option", "minDate", selectedDate);
//            }
//        });
//       $("#order_to_date").datepicker({
//            dateFormat: "yy-mm-dd",
//            defaultDate: "+1w",          
//            onClose: function(selectedDate) {
//                $("#order_from_date").datepicker("option", "maxDate", selectedDate);
//            }
//        });
//        $('#order_list').tablePagination(options);
        $("#order_list").tablesorter({headers: {0: {sorter: false},7: {sorter: false}}});
        $("#order_select_all").change(function() {

            if ($(this).is(":checked")) {
                var val1 = 1;

            }
            else
            {
                var val1 = 0;

            }
            if (val1 == 1) {
                $(".order_checkboxs").each(function() {
                    $(this).attr("checked", true);
                });
            }
            else if (val1 == 0) {
                $(".order_checkboxs").each(function() {
                    $(this).removeAttr("checked");
                });
            }

        });
        //bulk delete order.        
        $("#order_delete").click(function() {
            //get ticket ids from checked checkbox's id.
            var order_ids = jQuery('input.order_checkboxs:checkbox:checked').map(function() {
                return this.id;
            }).get();
            //count how many records are selected
            var count = 0;
            $(".order_checkboxs").each(function() {
                if ($(this).is(":checked"))
                {
                    count = count + 1;
                }
            });

            if (order_ids != '') {

                if (confirm('You are about to delete  ' + count + ' records are you sure?'))
                {
//                    alert(jQuery('#SITE_URL').val());

//               alert(order_ids);
                    $.ajax({//fetch the article via ajax            
                        type: "POST",
                        url: "orders/order_builk_delete", //calling this page
                        data: "order_ids=" + order_ids,
                        beforeSend: function() {
                            //jQuery("#indicator").show();
                        },
                        success: function(html) {
                            var response = $.parseJSON(html);
                            if (response.is_deleted == 1) {
                                jQuery('input.order_checkboxs:checkbox:checked').parents("tr").remove();
var rowCount = $('#order_list tr').length;                              
                               if(rowCount == 1){                                
                              $('#order_list > tbody:last').append('<tr><td colspan="9" class="fc-header-center">No Data found</td></tr>');
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
                alert('Please select any order to delete ');
            }
        });

    });
    function changestatus(status_id) {
        window.location = "<?php echo SITE_URL; ?>orders/index/?status=" + status_id;
    }
</script>


<div style="margin-bottom: 20px;">
    <?php echo $this->Form->create('Search', array('class' => 'form-inline row', 'id' => 'order_search')); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="col-md-4">

            </div><?php
            $st = "";
            if (isset($this->request->query['status'])) {
                $st = $this->request->query['status'];
            }
            ?>
            <div class="col-md-4">
                <?php echo $this->Form->input('Search.status', array('id' => 'status', 'class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => '', 'options' => Array('cancel', 'running', 'completed'), 'onchange' => 'changestatus(this.options[this.selectedIndex].value)', 'selected' => $st)); ?>                
            </div>



            <?php // echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'search'));  ?>
            <!--<button class="btn btn-primary" type="submit">Sign in</button>-->

            <!--<button type="button" class="btn btn-primary">Add Order</button>--><div class="col-md-4">
                <?php // echo $this->Html->link('Add New', '/orders/add', array('class' => 'btn btn-primary', 'style' => 'float:right')); ?>
                <span class="input-group-btn">
                    <?php echo $this->Form->button('Delete Selected', array('class' => 'btn btn-danger', 'style' => 'float:right', 'id' => 'order_delete'), __('are u delete?')); ?>
                    <!--<button type="button" class="btn btn-primary">Delete All Order</button>-->
                </span>
            </div>
        </div>
    </div>
</div>

<div class="widget widget-blue">
    <div class="widget-title">

        <h3><i class="icon-table"></i> Orders</h3>
    </div>
    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="order_list">
                <thead>
                    <tr>
                        <th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'order_select_all')); ?></div></th>
                <th>ID</th>
                <?php if ($grps != 5) { ?>
                    <th>Restaurant Name</th>
                <?php } ?> 
                <th style="width:100px;">Order Date</th>
                <th style="width:100px;">Table Name</th>
                <th style="width:100px;">User Name</th>

                <th>Total Amount</th>        
                <th style="width: 10px;"></th>
<!--                <th></th>
                <th></th>-->
                </tr>
                </thead>
                <tbody>

                    <tr>
                        <td></td>
                        <td></td>
                        <?php if ($grps != 5) { ?>
                            <td style="width:135px;"> <?php echo $this->Form->input('Search.rest_name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    </td>
                        <?php } ?> 
                        <td style="width:51px;"> <?php echo $this->Form->input('Search.order_date', array('id' => 'order_date', 'type' => 'text', 'class' => 'form-control input-daterangepicker', 'label' => false)); ?>    </td>
                        <td style="width:30px;"> <?php echo $this->Form->input('Search.table_name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    </td>
                        <td style="width:50px;"> <?php echo $this->Form->input('Search.user_name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    </td>

 <!--<td> <?php // echo $this->Form->input('Search.date_from', array('id' => 'order_from_date', 'type' => 'text', 'class' => 'form-control datepicker', 'label' => false));  ?>   <?php // echo $this->Form->input('Search.date_to', array('id' => 'order_to_date', 'type' => 'text', 'class' => 'form-control datepicker ', 'label' => false));  ?>       </td>-->
                        <td colspan="4" style="text-align:center;"> <?php
                            echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'search'));
                            if (isset($flag)) {
                                if ($flag == 'true') {
                                    echo $this->Html->link('View All', '/orders', array('class' => 'btn btn-primary'));
                                }
                            }
                            ?>   </td>
                    </tr>
                    <?php echo $this->Form->end(); ?>  
                    <?php
                    if (!empty($orders)) {
                        foreach ($orders as $order) {
                            ?>
                            <tr>
                                <td><div class="checkbox"><?php echo $this->Form->checkbox('order_id', array('id' => $order['Order']['id'], 'class' => 'order_checkboxs', 'hiddenField' => false)); ?></div></td>
                                <td><?php echo $order['Order']['id']; ?></td> 
                                <?php if ($grps != 5) { ?>
                                    <td><?php echo $order['Restaurant']['name']; ?></td>
                                <?php } ?> 
                                <td><?php echo $order['Order']['order_date']; ?></td>
                                <td><?php echo $order['RestaurantTable']['name']; ?></td>                                     
                                <td><?php echo $order['User']['first_name']; ?></td>

                                <td><?php echo $order['Order']['total_amount']; ?></td>                              
                                <td class="text-right">
                                    <?php echo $this->Html->link("View", '/orderItems/index/' . $order['Order']['id'], array('escape' => false, 'title' => 'View', 'class' => 'btn btn-default btn-xs')); ?>
                                    <!--<a class="btn btn-default btn-xs" href="#">edit</a>-->
                                    <?php // echo $this->Form->postLink("<i class='icon-remove'></i>", array('action' => 'delete', $order['Order']['id']), array('class' => 'btn btn-danger btn-xs remove-tr', 'escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $order['Order']['id']));   ?>
                                    <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
                                </td>
        <!--                                <td>  
                                <?php
//                                    if ($order['Order']['status'] == 1) {
//                                        $st = '2';
//                                        echo $this->Html->link("Completed", array('action' => 'change_status', $order['Order']['id'], $st), array('class' => 'btn btn-warning btn-xs remove-tr', 'escape' => false, 'title' => 'Active'), __('Are you sure you want to complete # %s this orderItem?', $order['Order']['id']));
//                                    }
                                ?>   </td> <td> <?php
//                                    if ($order['Order']['status'] == 1) {
//                                        $st = '0';
//                                        echo $this->Html->link("<i class='icon-remove'></i>", array('action' => 'change_status', $order['Order']['id'], $st), array('class' => 'btn btn-danger btn-xs remove-tr', 'escape' => false, 'title' => 'Active'), __('Are you sure you want to Cancel # %s this orderItem?', $order['Order']['id']));
//                                    }
                                ?></td>-->

                            </tr>

                            <?php
                        }
                    } else {
                        ?>
                        <tr><td colspan="9" class="fc-header-center">No Record found</td></tr>
                    <?php }
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
<!--                    <select class="per_page span2" id="tablePagination_rowsPerPage">
                <option value="5" selected="">5</option>
                <option value="15">15</option>
                <option value="25">25</option>
            </select>-->
            <span class="per_page">per page</span>                    
        </span>
        <ul id="tablePagination_paginater">                    
            <li>  <?php echo $this->paginator->first('|< first'); ?> </li>
            <li>  <?php echo $this->paginator->prev('<< prev', null, null, array('class' => 'prev disabled')); ?> </li>
            <li>   <?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a', 'escape' => false)); ?> </li>
            <li>   <?php echo $this->paginator->next('next >>', null, null, array('class' => 'next disabled')); ?> </li>
            <li>  <?php echo $this->paginator->last('last >|'); ?> </li>
            <li class="no_of_page"><?php echo $this->Paginator->counter(); ?></li>
                <?php
//                             echo $this->Paginator->first('first', array( 'tag' => 'li', 'escape' => false), null, array('class' => 'prev disabled prv' ,'tag' => 'li', 'escape' => false));
//                         echo $this->Paginator->prev('&laquo;', array( 'tag' => 'li', 'escape' => false), null, array('class' => 'prev disabled prv' ,'tag' => 'li', 'escape' => false));
//                         echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li' ,'currentClass' => 'active', 'currentTag' => 'a' , 'escape' => false));
//                         echo $this->Paginator->next('&raquo;', array( 'tag' => 'li', 'escape' => false), null, array('class' => 'next disabled nxt' ,'tag' => 'li', 'escape' => false));
//                          echo $this->Paginator->counter();
                ?>
        </ul>
    </div>
</div>
