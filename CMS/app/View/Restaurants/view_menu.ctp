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


<?

$categories = array();

//Create tree-like structure for categories and items
foreach ($category as $key=>$cat){

    //Insert category

    if (array_key_exists($cat['Category']['parent_id'], $categories)){
        //Parent category exists already, insert subcategory
        $parent_id = $cat['Category']['parent_id'];
        $sub_id = $cat['Category']['id'];
        $categories[$parent_id]['subcategories'][$sub_id] = $cat['Category'];

        if (!empty($cat['Item'])){
            //Insert items of subcategory
            $categories[$parent_id]['subcategories'][$sub_id]['items'] = $cat['Item'];
        }
    }
    else if (!array_key_exists($cat['Category']['id'], $categories)){
        //Insert parent category
        $categories[$cat['Category']['id']] = $cat['Category'];

        if (!empty($cat['Item'])){
            $categories[$cat['Category']['id']]['items'] = $cat['Item'];
        }
    }
}

$restaurant_name = $category[0]['Restaurant']['name'];
$restaurant_image= $category[0]['Restaurant']['image'];
$restaurant_address = $category[0]['Restaurant']['address'];
$restaurant_area = $category[0]['Restaurant']['area'];
$restaurant_city = $category[0]['Restaurant']['city'];
$restaurant_email = $category[0]['Restaurant']['email'];
$restaurant_number = $category[0]['Restaurant']['contact_no'];

?>
<div class="clearfix"></div>

<ul class="breadcrumb">
  <li><a href="<? echo SITE_URL . "restaurants" ?>">Restaurants</a> <span class="divider">/</span></li>
  <li class="active"><? echo $restaurant_name ?> <span class="divider">/</span></li>
  <li class="active">view menu</li>
</ul>
<?
    if ($restaurant_image == NULL)
        $restaurant_path = SITE_URL . "restaurant_images/place_holder_squre.png";
    else
        $restaurant_path = SITE_URL . "restaurant_images/" . $restaurant_image;
?>
<div class="row">
    <div class="span2">
<?
echo $this->Html->image($restaurant_path, array('class' => 'img-polaroid',
                                                'style' =>'height: 120px;
                                                           float: left;
                                                           margin: 5px;'));
?>
    </div>
    <div class="span4">
        <address style="margin-top:35px;">
            <strong><? echo $restaurant_name ?></strong><br>
            <? echo $restaurant_address ?>, <? echo $restaurant_area ?><br>
            <? echo $restaurant_city?><br>
            <abbr title="Phone">phone:</abbr> <? echo $restaurant_number ?><br>
            <a href="mailto:<? echo $restaurant_number ?>"><? echo $restaurant_email ?></a>
        </address>
    </div>
</div>

<div class="clearfix"></div>

<div class="accordion" id="accordion2">
<? foreach ($categories as $key=>$cat) { ?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<? echo $key;?>">
                <h3>
                <? if ($cat['icon'] == NULL)
                       $icon_path = SITE_URL . "category_images/place_holder_squre.png";
                   else
                        $icon_path = SITE_URL . "category_images/" . $cat['icon'];
                   echo $this->Html->image($icon_path,
                                          array('class' => 'img-circle',
                                                'style' =>'height: 40px;
                                                           width: 40px;
                                                           float: left;
                                                           margin-right: 5px;'));
                ?>
                    <!-- <img src="http://localhost/category_images/4_drinks.jpg"
                         class="img-circle" style="height: 40px; width: 40px; float: left; margin-right: 5px;"> -->
                       <?php echo $cat['name']; ?>
                </h3>
            </a>
        </div>
        <div id="collapse<? echo $key;?>" class="accordion-body collapse">
            <div class="accordion-inner">
                <blockquote>
                    <p><?php echo $cat['description']; ?></p>
                </blockquote>
                
                <? if ( array_key_exists('subcategories', $cat) and (!(count($cat['subcategories']) == 0))){ ?>
                    <div class="accordion" id="accordion3">
                        <? foreach ($cat['subcategories'] as $id => $sub) { ?>

                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapse<? echo $id; ?>">
                                    <h4><?
                                        if ($sub['icon'] == NULL)
                                            $icon_path = SITE_URL . "category_images/place_holder_squre.png";
                                        else
                                            $icon_path = SITE_URL . "category_images/" . $sub['icon'];
                                            echo $this->Html->image($icon_path,
                                                                    array('class' => 'img-circle',
                                                                          'style' =>'height: 20px;
                                                                                     width: 20px;
                                                                                     float: left;
                                                                                     margin-right: 5px;'));
                ?>
                                    <? echo $sub['name']; ?></h4>
                                </a>
                                
                            </div>
                            <div id="collapse<? echo $id; ?>" class="accordion-body collapse in">
                                <div class="accordion-inner">
                                    <p><blockquote> <?php echo $sub['description']; ?> </blockquote></p>
                                    <table class="table table-hover">
                                        <tr>
                                            <td><b>Item Name</b></td>
                                            <td><b>Description</b></td>
                                            <td><b>Price</b></td>
                                            <td></td>
                                        </tr>
                                            <? foreach ($sub['items'] as $item) { ?>
                                        <tr>
                                            <td><?php echo $item['name']; ?></td>
                                            <td><?php echo $item['description']; ?></td>
                                            <td><?php echo $this->Number->currency($item['price'], 'EUR'); ?></td>
                                            <td><? echo $this->Html->link("View Gallery ", '/Suggestions/index/' . $item['id'], array('escape' => false, 'title' => 'Edit')); ?></td>
                                        </tr>
                                        <? } ?>
                                  </table>
                                </div>
                            </div>
                        </div>
                        <? } ?>
                    </div>
                <? } ?>



            </div>
        </div>
    </div>
<? } ?>
</div>
