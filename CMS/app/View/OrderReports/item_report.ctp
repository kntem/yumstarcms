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
//        $('#orderItem_list').tablePagination(options);
        $("#orderItem_list").tablesorter({headers: {0: {sorter: false}}});
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
        

    });
    function changesuser(user_id) {
        window.location = "<?php echo SITE_URL; ?>OrderReports/item_report/?user=" + user_id;
    }
</script>


<div style="margin-bottom: 50px;">
             <?php echo $this->Form->create('Search', array('class' => 'form-inline row', 'id' => 'userSetting_search','style'=>'float:left')); ?>
                              <div class="form-group">                               
                                <?php echo $this->Form->input('Search.order_date', array('id' => 'order_date', 'type' => 'text', 'class' => 'form-control input-daterangepicker', 'label' => false)); ?>
                              </div>
                                <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success','id'=>'search')); ?>
                             
                               <?php 
                                if(isset($flag)) {
         if($flag=='true') {
  
                                echo $this->Html->link('View All', '/orderReports/item_report/'.$ids, array('class' => 'btn btn-primary')); 
                                }}
                                echo $this->Form->end();
                                ?>  
      </div>
<div class="clearfix"></div>
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
                    <th>Restaurant Name</th>
                    <th>Table Name</th>

                    <th>User Name</th>
                    <th>Item Name</th>              
                    <th>Quantity</th>              
                    <th>Date Time</th>   
                    <th>Debt</th>   

                    <th>Total</th>              

                    </tr>
                    </thead>
                    <tbody>
                        <?php echo $this->Form->create('Search', array('class' => 'form-inline row', 'id' => 'order_item_search')); ?>
    <!--                    <tr>
                            <td></td>
                            <td></td>
                            <td><?php echo $this->Form->input('Search.table_name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?></td>
                            <td> <?php echo $this->Form->input('Search.item_name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    </td>
                            <td> <?php echo $this->Form->input('Search.category_name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    </td>
                            <td>  </td>
                            <td> <?php echo $this->Form->input('Search.item_choice', array('id' => 'order_date', 'type' => 'text', 'class' => 'form-control datepicker', 'label' => false)); ?>    </td>
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
                        </tr>-->
                        <?php echo $this->Form->end(); ?>  
                        <?php $grd_total_debt=0;
$grd_total=0;
//                    pr($orderItems);
//                   exit();
                        if (!empty($orderItems)) {
//                            pr($orderItems);

                            foreach ($orderItems as $orderItem) {
                                $item_id = $orderItem['OrderItem']['item_id'];
//                            App::import("Controller", "Categories");  // load model category
//                            $Category = new CategoriesController();
//                            $Category_list = $Category->get_category($item_id); // here check_if_holiday is a method inside PublicHoliday Model
                                ?>
                                <tr>
                                    <td><div class="checkbox"><?php echo $this->Form->checkbox('orderItem_id', array('id' => $orderItem['OrderItem']['id'], 'class' => 'orderItem_checkboxs', 'hiddenField' => false)); ?></div></td>
                                    <td><?php echo $orderItem['OrderItem']['id']; ?></td>     
                                    <td><?php echo $orderItem['Restaurant']['name']; ?></td>     
                                    <td><?php echo $orderItem['RestaurantTable']['name']; ?></td>     
                                    <td><?php echo $orderItem['User']['username']; ?></td>     
                                    <td><?php echo $orderItem['Item']['name']; ?></td>

                                    <td><?php echo $orderItem['OrderItem']['quantity']; ?></td>


                                    <td>  <?php
                                        echo $date = $orderItem['Order']['order_date'];
//                                 echo $time = date('H:i:s' , strtotime($date));
                                        ?></td>                        
                                    <td><?php $rate=$orderItem['UserSetting']['bill_rate'];
                                              $total=$orderItem['Order']['total_amount'];
                                              $debt=($rate*$total)/100 ;
                                              $grd_total_debt = $grd_total_debt +$debt;
                                              $grd_total =$grd_total+$total;
                                               echo $this->Number->currency($debt,'USD');?></td>
                                    <td><?php echo $this->Number->currency($orderItem['Order']['total_amount'],'USD'); ?></td>
                                </tr>
                                <?php
                                
                            }
                        }
                        else{
                        ?>
                                <tr><td colspan="10">No Data Found</td></tr>
                        <?php }?>
                                <tr><td colspan="8" style="text-align:right;"><b>Total:</b></td><td><?php echo $this->Number->currency($grd_total_debt,'USD'); ?></td><td><?php echo $this->Number->currency($grd_total,'USD'); ?></td></tr>
                    </tbody>
                </table>
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
                        <?php 
                        $this->paginator->options(array('url' => $this->passedArgs)); ?>
                        <li>  <?php echo $this->paginator->first('|< first'); ?> </li>
                        <li>  <?php echo $this->paginator->prev('<< prev', null, null, array('class' => 'prev disabled')); ?> </li>
                        <li>   <?php echo $this->Paginator->numbers(); ?> </li>
                        <li>   <?php echo $this->paginator->next('next >>', null, null, array('class' => 'next disabled')); ?> </li>
                        <li>  <?php echo $this->paginator->last('last >|'); ?> </li>
                        <li><?php echo $this->Paginator->counter(); ?></li>
                        <?php
                        //      echo $this->Paginator->prev('first', array( 'tag' => 'li', 'escape' => false), null, array('class' => 'prev disabled prv' ,'tag' => 'li', 'escape' => false));
                        // echo $this->Paginator->prev('&laquo;', array( 'tag' => 'li', 'escape' => false), null, array('class' => 'prev disabled prv' ,'tag' => 'li', 'escape' => false));
                        // echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li' ,'currentClass' => 'active', 'currentTag' => 'a' , 'escape' => false));
                        // echo $this->Paginator->next('&raquo;', array( 'tag' => 'li', 'escape' => false), null, array('class' => 'next disabled nxt' ,'tag' => 'li', 'escape' => false));
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
