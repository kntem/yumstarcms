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
                        url: 'orderItems/orderItem_builk_delete', //calling this page
                        data: "orderItem_ids=" + orderItem_ids,
                        beforeSend: function() {
                            //jQuery("#indicator").show();
                        },
                        success: function(html) {
                            var response = $.parseJSON(html);
                            if (response.is_deleted == 1) {
                                jQuery('input.orderItem_checkboxs:checkbox:checked').parents("tr").remove();
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
                alert('Please select any orderItem to delete ');
            }
        });

    $(".collapse").collapse();

    });
    function changestatus(status) {
       var id = $("#status").attr("id-amj");
        window.location = "<?php echo SITE_URL; ?>OrderReports/item_stat/"+id+"?status=" + status;
    }
</script>

<!--
  <div style="margin-bottom: 20px;">
           <div class="row">
             <?php //  phpinfo();
             echo $this->Form->create('Search', array('class' => 'form-inline', 'id' => 'userSetting_search')); ?>
                                <?php // echo $this->Form->input('Search.order_date', array('id' => 'order_date', 'type' => 'text', 'class' => 'form-control input-daterangepicker', 'label' => false,'placeholder'=>'Restaurant Name')); ?>
                                  <div class="col-sm-2">
                                <?php // echo $this->Form->input('Search.name', array('id' => 'name', 'type' => 'text', 'class' => 'form-control ', 'label' => false,'placeholder'=>'Restaurant Name')); ?>
                                  </div>
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
                             <div class="col-sm-2">
                               <?php 
                                if(isset($flag)) {
         if($flag=='true') {
                                echo $this->Html->link('View All', '/orderReports/item_stat/'.$rid, array('class' => 'btn btn-primary')); 
                                }}
                                echo $this->Form->end();
                                ?>  
                             </div>
                              </div></div>-->



<div class="accordion" id="accordion2">
<? foreach ($category as $key=>$cats) { ?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<? echo $key;?>">
                <h3>
                <? if ($cats['Category']['icon'] == NULL)
                       $icon_path = SITE_URL . "category_images/place_holder_squre.png";
                   else
                        $icon_path = SITE_URL . "category_images/" . $cats['Category']['icon'];
                   echo $this->Html->image($icon_path,
                                          array('width' => '40',
                                                'height' => '40',
                                                'class' => 'img-circle',
                                                'style' =>'height: 40px;
                                                           width: 40px;
                                                           float: left;
                                                           margin-right: 5px;'));
                ?>
                    <!-- <img src="http://localhost/category_images/4_drinks.jpg"
                         class="img-circle" style="height: 40px; width: 40px; float: left; margin-right: 5px;"> -->
                       <?php echo $cats['Category']['name']; ?>
                </h3>
            </a>
        </div>
        <div id="collapse<? echo $key;?>" class="accordion-body collapse">
            <div class="accordion-inner">
                <blockquote>
                    <p><?php echo $cats['Category']['description']; ?></p>
                </blockquote>
                <table class="table table-hover">
                    <tr>
                        <td>Item Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>View gallery</td>
                    </tr>
                        <? foreach ($restaurant['Item'] as $items) {
                            if ($items['category_id'] == $cats['Category']['id']) {
                        ?>
                    <tr>
                        <td><?php echo $items['name']; ?></td>
                        <td><?php echo $items['description']; ?></td>
                        <td><?php echo $this->Number->currency($items['price'], 'EUR'); ?></td>
                        <td><? echo $this->Html->link("View Gallery ", '/Suggestions/index/' . $items['id'], array('escape' => false, 'title' => 'Edit')); ?></td>
                    </tr>
                    <? }} ?>
                </table>
            </div>
        </div>
    </div>
<? } ?>
</div>



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
                        <th>Description</th>
                        <th>Price</th>
                        <th>Icon</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($restaurant)) {
                    if (!empty($category)) {


                        foreach ($category as $cats) {
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
                                <td><?php echo $cats['Category']['description']; ?></td>
                                <td></td>

                                <td><?php
                                    if ($cats['Category']['icon'] == NULL) {
                                        $icon_path = SITE_URL . "category_images/place_holder_squre.png";
                                        echo $this->Html->link($this->Html->image($icon_path, array('width' => '50',
                                                                                                    'height' => '50')),
                                                               $icon_path,
                                                               array('class' => 'fancybox',
                                                                     'escape' => false,
                                                                     'data-fancybox-group' => 'button'));
                                    } else {
                                        $icon_path = SITE_URL . "category_images/" . $cats['Category']['icon'];
                                        echo $this->Html->link($this->Html->image($icon_path, array('width' => '50', 
                                                                                                    'height' => '50')),
                                                               $icon_path,
                                                               array('class' => 'fancybox',
                                                                     'escape' => false, 
                                                                     'data-fancybox-group' => 'button'));
                                    }
                                    ?></td>
                            </tr>
        <?php
        if (!empty($restaurant['Item'])) {

            foreach ($restaurant['Item'] as $items) {
//                            pr($items);
                if ($items['category_id'] == $cats['Category']['id']) {
                    ?>   <tr>

                                            <td><?php echo $items['id']; ?></td>
                                            <td></td>
                                            <td><?php echo $items['name']; ?></td>
                                            <td><?php echo $items['description']; ?></td>
                                            <td><?php echo $this->Number->currency($items['price'], 'EUR'); ?></td>

                                            <td>  <?php
                                        echo $this->Html->link("View Gallery ", '/Suggestions/index/' . $items['id'], array('escape' => false, 'title' => 'Edit', 'class' => 'btn btn-primary btn-xs'));
                                    ?></td>



                                        </tr>
                    <?php
                }
            }
        }
        ?>
                    <?php
                }
                    } }else {
                ?>
                        <tr><td colspan="6" class="fc-header-center">No Data Found</td></tr>
            <?php } ?>

                </tbody>
            </table>

        </div>
    </div>
    <div class="pagination_outer pagination pagination-right pagination-mini" id="tablePagination">
        <div id="tablePagination_perPage">
        <?php
            if (isset($this->params->query['limit'])) {
                $limit = $this->params->query['limit'];
//            echo "Limit : ".$limit;
            }
            else {
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
                                     'class' => 'per_page span2',
                                     'style'     => 'width:auto'
                                     )
                                    );
            echo $this->Form->end();
            ?>
            <span class="per_page">per page</span>
        </div>
        <div>
            <ul id="tablePagination_paginater">
                <li>  <?php echo $this->paginator->first('|< first'); ?> </li>
                <li>  <?php echo $this->paginator->prev('<< prev', null, null, array('class' => 'prev disabled')); ?> </li>
                <li>  <?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a', 'escape' => false)); ?> </li>
                <li>  <?php echo $this->paginator->next('next >>', null, null, array('class' => 'next disabled')); ?> </li>
                <li>  <?php echo $this->paginator->last('last >|'); ?> </li>
                <li class="no_of_page"><?php echo $this->Paginator->counter(); ?></li>
            </ul>
        </div>
    </div>
</div>
