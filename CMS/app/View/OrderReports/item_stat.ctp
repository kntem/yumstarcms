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
    function changestatus(status) {
       var id = $("#status").attr("id-amj");
        window.location = "<?php echo SITE_URL; ?>OrderReports/item_stat/"+id+"?status=" + status;
    }
</script>


  <div style="margin-bottom: 20px;">
           <div class="row">
        
             <?php echo $this->Form->create('Search', array('class' => 'form-inline', 'id' => 'userSetting_search')); ?>
                                                         
                                <?php // echo $this->Form->input('Search.order_date', array('id' => 'order_date', 'type' => 'text', 'class' => 'form-control input-daterangepicker', 'label' => false,'placeholder'=>'Restaurant Name')); ?>
<!--                                  <div class="col-sm-2">
                                <?php // echo $this->Form->input('Search.name', array('id' => 'name', 'type' => 'text', 'class' => 'form-control ', 'label' => false,'placeholder'=>'Restaurant Name')); ?>
                                  </div>    -->
<?php
            $st = "";
            if (isset($this->request->query['status'])) {
                $st = $this->request->query['status'];
            }
            ?>
            <div class="col-md-2">
                <?php echo $this->Form->input('Search.status', array('id' => 'status', 'id-amj'=>$rid,'class' => 'required form-control', 'label' => false, 'type' => 'select', 'empty' => 'All', 'options' => Array('cancel', 'running', 'completed'), 'onchange' => 'changestatus(this.options[this.selectedIndex].value)', 'selected' => $st,'')); ?>                
            </div>
<div class="col-sm-1">                        
                                    
                                 <?php echo $this->Form->input('Search.year', array('type' => 'select','empty' => 'Select Year','options'=>$year,'label'=>false, 'class' => 'form-control ','id'=>'year')); ?>
                                              </div><div class="col-sm-1">
                                                  <?php echo $this->Form->input('Search.mon', array('type' => 'select','options'=>$mon,'empty' => 'Select Month','label'=>false, 'class' => 'form-control ','id'=>'month')); ?>
                               </div><div class="col-sm-1">
                                   <?php echo $this->Form->input('Search.day', array('type' => 'select','options'=>$day,'empty' => 'Select Day','label'=>false, 'class' => 'form-control ','id'=>'day')); ?>
                                          </div>
                               
                                       <label class="col-sm-1 control-label">Total Amount:</label>
                                       <div class="col-sm-2">
                                                  <?php echo $this->Form->input('Search.famt', array('id' => 'famt', 'type' => 'text', 'class' => 'form-control ', 'label' => false,'placeholder'=>'Minimum Amount')); ?>
                               </div><div class="col-sm-2">
                                                  <?php echo $this->Form->input('Search.lamt', array('id' => 'lamt', 'type' => 'text', 'class' => 'form-control ', 'label' => false,'placeholder'=>'Maximum Amount')); ?>
                               </div>
                                 
                                  <div class="col-sm-2">
                                <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success','id'=>'search')); ?>
                                                   </div>
                             <div class="col-sm-12">
                               <?php 
                                if(isset($flag)) {
         if($flag=='true') {
  
                                echo $this->Html->link('View All', '/orderReports/item_stat/'.$rid, array('class' => 'btn btn-primary btn-view')); 
                                }}
                                echo $this->Form->end();
                                ?>  
                             </div>
                              </div></div>
<div class="clearfix"></div>
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

                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Item Name</th>

                        <th>Orders</th>
                        <th>Revenue</th>              
                        <th>photos/Likes</th>            


                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($cat)) {


                        foreach ($cat as $cats) {
//                                 pr($cats);
//                                $item_id = $orderItem['OrderItem']['item_id'];
//                            App::import("Controller", "Categories");  // load model category
//                            $Category = new CategoriesController();
//                            $Category_list = $Category->get_category($item_id); // here check_if_holiday is a method inside PublicHoliday Model
                            ?>    
                            <tr>

                                <td><?php echo $cats['Category']['id']; ?></td>     
                                <td><?php echo $cats['Category']['name']; ?></td>     
                                <td></td>     
                                <td><?php echo $cats[0]['total_ord']; ?></td>     
                                <td><?php echo $this->Number->currency($cats[0]['total_cum'], 'EUR'); ?></td>

                                <td><?php
                                    if (!empty($sugcat)) {

                                        foreach ($sugcat as $sugcats) {
//                                            pr($sugcats);
                                            if ($sugcats['Item']['category_id'] == $cats['Category']['id']) {
                                                echo $sugcats[0]['tot_sug'];
//                                                break;
                                            }
                                        }
                                    }
                                    if (!empty($likecat)) {
                                        foreach ($likecat as $likecats) {
//                                            pr($likecats);
                                            if ($likecats['Item']['category_id'] == $cats['Category']['id']) {
                                                echo '/'.$likecats[0]['tot_like'];
//                                                break;
                                            }
                                        }
                                    }
                                    if (!empty($updatecategory)) {
                                        foreach ($updatecategory as $updatecategories) {
//                                            pr($updatecategories);
                                            if ($updatecategories['Item']['category_id'] == $cats['Category']['id']) {
                                                echo '/'.$updatecategories[0]['tot_update'];
//                                                break;
                                            }
                                            
                                        }
                                    }
                                    ?></td></tr>
        <?php
        if (!empty($item)) {

            foreach ($item as $items) {
//                            pr($items);
                if ($items['Item']['category_id'] == $cats['Item']['category_id']) {
                    ?>   <tr>

                                            <td><?php echo $items['Item']['id']; ?></td>     
                                            <td></td>     
                                            <td><?php echo $items['Item']['name']; ?></td>     
                                            <td><?php echo $items[0]['total_ord']; ?></td>     
                                            <td><?php echo $this->Number->currency($items[0]['total_cum'], 'EUR'); ?></td>

                                            <td><?php
                            if (!empty($sug)) {
                                foreach ($sug as $sugs) {
                                    if ($sugs['Suggestion']['Item_id'] == $items['Item']['id']) {
                                        if($sugs[0]['tot_sug']==''){
                                            echo '0';
                                        }
                                        else{
                                            echo $sugs[0]['tot_sug'];
                                        }
                                    }
                                }
                            }
                            if (!empty($like)) {
                                foreach ($like as $likes) {
                                    if ($likes['Suggestion']['Item_id'] == $items['Item']['id']) {
                                        if($likes[0]['tot_like'] == '')
                                        {
                                        echo '/0';
                                        }else{
                                          
                                        echo '/'.$likes[0]['tot_like'];
                                    }
                                }
                            }}
                              if (!empty($updateitem)) {
                                foreach ($updateitem as $updateitems) {
                                    if ($updateitems['Suggestion']['Item_id'] == $items['Item']['id']) {
                                        
                                      if($updateitems[0]['tot_update'] == '')
                                        {
                                        echo '/'.'0';
                                        }else{
                                          
                                        echo '/'.$updateitems[0]['tot_update'];
                                        }
                                    }
                                }
                            }
                    ?></td>



                                        </tr>
                    <?php
                }
            }
        }
        ?>
                    <?php
                }
            } else {
                ?>
                        <tr><td colspan="6" class="fc-header-center">No Data Found</td></tr>
            <?php } ?>

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
