<script type="text/javascript">
    $(document).ready(function() {

        var options = {
            currPage: 1,
            optionsForRows: [15, 25],
            rowsPerPage: 5,
            topNav: false
        }
//        $('#restaurant_list').tablePagination(options); 
        $("#restaurant_list").tablesorter({headers: {0: {sorter: false},8: {sorter: false},9: {sorter: false}}});

        $("#restaurant_select_all").click(function() {

            if ($(this).is(":checked")) {
                $(".restaurant_checkboxs").each(function() {
                    $(this).attr("checked", "checked");
                });
            }
            else
            {
                $(".restaurant_checkboxs").each(function() {
                    $(this).removeAttr("checked");
                });
            }
        });
        //bulk delete ticket.
        $("#restaurant_delete").click(function() {
            //get ticket ids from checked checkbox's id.
            var restaurant_ids = jQuery('input.restaurant_checkboxs:checkbox:checked').map(function() {
                return this.id;
            }).get();
            //count how many records are selected
            var count = 0;
            $(".restaurant_checkboxs").each(function() {
                if ($(this).is(":checked"))
                {
                    count = count + 1;
                }
            });

            if (restaurant_ids != '') {

                if (confirm('You are about to delete  ' + count + ' records are you sure?'))
                {
//                    alert(jQuery('#SITE_URL').val());


                    $.ajax({//fetch the article via ajax
                        type: "POST",
                        url: 'restaurants/restaurant_builk_delete', //calling this page
                        data: "restaurant_ids=" + restaurant_ids,
                        beforeSend: function() {
                            //jQuery("#indicator").show();
                        },
                        success: function(html) {
                            var response = $.parseJSON(html);
                            if (response.is_deleted == 1) {
                                jQuery('input.restaurant_checkboxs:checkbox:checked').parents("tr").remove();
                                var rowCount = $('#restaurant_list tr').length;
                                if(rowCount == 1){
                                    $('#restaurant_list > tbody:last').append('<tr><td colspan="9" class="fc-header-center">No Data found</td></tr>');
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
                alert('Please select any restaurant to delete ');
            }
        });
        $(".fancybox").fancybox({
            openEffect: 'elastic',
            closeEffect: 'elastic',
            helpers: {
                title: {
                    type: 'inside'
                }
            }
        });

        $('.dropdown-toggle').dropdown();

    });
</script>
<?php
// if(isset($this->request->query['qid'])){
//    $qid=$this->request->query['qid'];
//   $codeContents  = 'Restaurant_id:'.$qid."\n";
//    $codeContents .= 'table_id:1';
//
//$this->QrCode->id_qr($codeContents,$qid); } 
?>

<div style="margin-bottom: 20px;">
    <!--<button type="button" class="btn btn-primary">Add Restaurant</button>-->

    <div class="row">
        <div class="span4">
            <?php echo $this->Form->create('Search', array('class' => 'form-inline', 'id' => 'restaurant_search')); ?>
            <?php echo $this->Form->input('Search.name', array('type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Business Name')); ?>
            <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'search')); ?>
            <?php
            if (isset($flag)) {
                if ($flag == 'true') {
                    echo $this->Html->link('View All', '/restaurants', array('class' => 'btn btn-primary'));
                }
            }
            echo $this->Form->end();
            ?>
        </div>

        <div class="offset1 span4  text-right">
<?php echo $this->Html->link('Add New', '/restaurants/add', array('class' => 'btn btn-primary', 'style' =>'margin-right:5px;')); ?>
<?php echo $this->Form->button('Delete Selected', array('class' => 'btn btn-danger', 'id' => 'restaurant_delete'), __('are u delete?')); ?>

        </div>
    </div>
</div>
<div class="widget widget-blue">
    <div class="widget-title">
        <h3><i class="icon-table"></i> Businesses </h3>
    </div>
    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="restaurant_list">
                <thead>
                <tr>
                    <th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'restaurant_select_all')); ?></div></th>
                    <th style="min-width:25px;">ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Area</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th style="min-width: 64px;"></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($restaurants)) {
                        foreach ($restaurants as $restaurant) {
                            ?>
                            <tr>
                                <td><div class="checkbox"><?php echo $this->Form->checkbox('restaurant_id', array('id' => $restaurant['Restaurant']['id'], 'class' => 'restaurant_checkboxs', 'hiddenField' => false)); ?></div></td>
                                <td><?php echo $restaurant['Restaurant']['id']; ?></td>
                                <td><?php echo $restaurant['Restaurant']['name']; ?></td>
                                <td><?php echo $restaurant['Restaurant']['address']; ?></td>
                                <td><?php echo $restaurant['Restaurant']['area']; ?></td>
                                <td><?php echo $restaurant['Restaurant']['city']; ?></td>
                                <td><?php echo $restaurant['Restaurant']['email']; ?></td>
                                <td><?php echo $restaurant['Restaurant']['contact_no']; ?></td>
                                <td><?php
                                    if ($restaurant['Restaurant']['image'] == NULL) {
                                        $icon_path = SITE_URL . "restaurant_images/place_holder_squre.png";
                                        echo $this->Html->link($this->Html->image($icon_path, array('width' => '50', 'height' => '50')), $icon_path, array('class' => 'fancybox', 'escape' => false, 'data-fancybox-group' => 'button'));
                                    } else {
                                        $icon_path = SITE_URL . "restaurant_images/" . $restaurant['Restaurant']['image'];
                                        echo $this->Html->link($this->Html->image($icon_path, array('width' => '50', 'height' => '50')), $icon_path, array('class' => 'fancybox', 'escape' => false, 'data-fancybox-group' => 'button'));
                                    }
                                    ?></td>
                                <!--<td><span class="label label-success">Active</span></td>-->
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Options <b class="caret"></b> </a>
                                        <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel" align="left">

                                            <li>
                                                    <?php echo $this->Html->link("<i class='icon-th-large icon-white'></i> Tables", '/restaurantTables/index/' . $restaurant['Restaurant']['id'], array('escape' => false, 'title' => 'Table')); ?>
                                            </li>
                                            <li><?php // echo $this->Html->link("Qrcode", array('controller' => 'Qrcodes','action' => 'view', $restaurant['Restaurant']['id']), array('class' => 'btn btn-default btn-xs', 'target' => '_blank'));?>
                                            <li><?php echo $this->Html->link("<i class='icon-edit icon-white'></i> Edit Business", '/restaurants/edit/' . $restaurant['Restaurant']['id'], array('escape' => false, 'title' => 'Edit Business')); ?></li>
                                            <li><?php echo $this->Html->link("<i class='icon-glass icon-white'></i> View Menu", '/restaurants/view_menu/' . $restaurant['Restaurant']['id'], array('escape' => false, 'title' => 'View Menu')); ?></li>
                                            <li><?php echo $this->Html->link("<i class='icon-star-empty icon-white'></i> View Item's Stats", '/OrderReports/item_stat/' . $restaurant['Restaurant']['id'], array('escape' => false, 'title' => 'View Item\'s Stats')); ?></li>
                                            <li><?php echo $this->Html->link("<i class='icon-th-list icon-white'></i> View History", '/restaurants/edit/' . $restaurant['Restaurant']['id'], array('escape' => false, 'title' => 'View History')); ?></li>
                                            <li><?php echo $this->Html->link("<i class='icon-pencil icon-white'></i> Edit Menu", '/categories/index?rest_id=' . $restaurant['Restaurant']['id'], array('escape' => false, 'title' => 'Edit Menu')); ?></li>
                                            <!--<li><a class="btn btn-default btn-xs" href="#">edit</a></li>-->
                                            <li role="presentation" class="divider"></li>
                                            <li><?php echo $this->Form->postLink("<i class='icon-remove'></i> Delete", array('action' => 'delete', $restaurant['Restaurant']['id']), array('escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $restaurant['Restaurant']['name'])); ?></li>
                                            <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                        <?php }
                    }else{
                    ?>
                            <tr><td colspan="9" class="fc-header-center">No Data Found</td></tr>
                    <?php }
                    // $ar1=array('controller' => 'Restaurants', 'action' => 'edit', 2);
//        echo $this->QrCode->url($ar1); 
?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="pagination_outer pagination pagination-right pagination-mini" id="tablePagination">
        <div id="tablePagination_perPage" style="margin-right:5px;">
        <?php
            if (isset($this->params->query['limit'])) {
                $limit = $this->params->query['limit'];
//            echo "Limit : ".$limit;
            } else {
                $limit = 5;
            }
            $options = array('5' => 5, '10' => 10, '20' => 20);

            echo $this->Form->create(array('type' => 'get'));

            echo $this->Form->select('limit', $options, array(
                                     'value'     => $limit,
                                     'default'   => $limit,
                                     'onChange'  => 'this.form.submit();',
                                     'name'      => 'limit',
                                     'id'        => 'tablePagination_rowsPerPage',
                                     'class'     => 'per_page span2',
                                     'style'     => 'width:auto'
                                     )
                                    );
            echo $this->Form->end();
            ?>
<!--                    <select class="per_page span2" id="tablePagination_rowsPerPage">
                <option value="5" selected="">5</option>
                <option value="15">15</option>
                <option value="25">25</option>
            </select>-->
            <small class="per_page">per page</small>
        </div>
        <ul id="tablePagination_paginater">
            <li>  <?php echo $this->paginator->first('|< first'); ?> </li>
            <li>  <?php echo $this->paginator->prev('<< prev', null, null, array('class' => 'prev disabled')); ?> </li>
            <li>  <?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a', 'escape' => false)); ?> </li>
            <li>  <?php echo $this->paginator->next('next >>', null, null, array('class' => 'next disabled')); ?> </li>
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

