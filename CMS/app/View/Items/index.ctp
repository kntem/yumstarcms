<script type="text/javascript">
    $(document).ready(function() {

        var options = {
            currPage: 1,
            optionsForRows: [15, 25],
            rowsPerPage: 5,
            topNav: false
        }
//        $('#item_list').tablePagination(options);
        $("#item_list").tablesorter({headers: {0: {sorter: false},7: {sorter: false}}});
        $("#item_select_all").change(function() {
            if ($(this).is(":checked")) {
                var val1 = 1;
            }
            else
            {
                var val1 = 0;
            }
            if (val1 == 1) {
                $(".item_checkboxs").each(function() {
                    $(this).attr("checked", true);
                });
            }
            else if (val1 == 0) {
                $(".item_checkboxs").each(function() {
                    $(this).removeAttr("checked");
                });
            }
        });
        //bulk delete item.        
        $("#item_delete").click(function() {
            //get ticket ids from checked checkbox's id.
            var item_ids = jQuery('input.item_checkboxs:checkbox:checked').map(function() {
                return this.id;
            }).get();
            //count how many records are selected
            var count = 0;
            $(".item_checkboxs").each(function() {
                if ($(this).is(":checked"))
                {
                    count = count + 1;
                }
            });

            if (item_ids != '') {

                if (confirm('You are about to delete  ' + count + ' records are you sure?'))
                {
//                    alert(jQuery('#SITE_URL').val());


                    $.ajax({//fetch the article via ajax            
                        type: "POST",
                        url: 'items/item_builk_delete', //calling this page
                        data: "item_ids=" + item_ids,
                        beforeSend: function() {
                            //jQuery("#indicator").show();
                        },
                        success: function(html) {
                            var response = $.parseJSON(html);
                            if (response.is_deleted == 1) {
//                                window.reload();
                                jQuery('input.item_checkboxs:checkbox:checked').parents("tr").remove();
 var rowCount = $('#item_list tr').length;                              
                               if(rowCount == 1){                                
                              $('#item_list > tbody:last').append('<tr><td colspan="7" class="fc-header-center">No Data found</td></tr>');
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
                alert('Please select any item to delete ');
            }
        });

    });
</script>


<div style="margin-bottom: 20px;">
    
       <div class="row">
        <div class="col-xs-7 col-md-6">
            <?php echo $this->Form->create('Search', array('class' => 'form-inline', 'id' => 'item_search')); ?>
    <div class="form-group col-xs-9">                               
        <?php echo $this->Form->input('Search.name', array('type' => 'text', 'class' => 'form-control ', 'label' => false,'placeholder'=>'Item Name')); ?>    
    </div>
        
    <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success col-xs-2 ', 'id' => 'search')); ?>
 
    <?php
    if (isset($flag)) {
        if ($flag == 'true') {

            echo $this->Html->link('View All', '/items', array('class' => 'btn btn-primary'));
        }
    }
    echo $this->Form->end();
    ?>
        </div>
     <div class="col-xs-5 col-md-6 text-right">
        <?php echo $this->Html->link('Add New', '/items/add', array('class' => 'btn btn-primary')); ?>
    
<?php echo $this->Form->button('Delete Selected', array('class' => 'btn btn-danger', 'id' => 'item_delete'), __('are u delete?')); ?>
  
     </div>
</div>
</div>
<div class="widget widget-blue">
    <div class="widget-title">

        <h3><i class="icon-table"></i> Items</h3>
    </div>
    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="item_list">
                <thead>
                    <tr>
                        <th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'item_select_all')); ?></div></th>
                <th>ID</th>
                <?php if ($grp_id != 5) { ?>
                    <th style="width: 130px;">Restaurant Name </th>
<?php } ?>
                <th style="width: 120px;">Category Name</th>
                <th style="width: 100px;">Item Name</th>
                <th>Description</th>
                <th>price</th>
                <th style="width: 115px;"></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($items)) {
                        foreach ($items as $item) {
                            ?>
                            <tr>
                                <td><div class="checkbox"><?php echo $this->Form->checkbox('item_id', array('id' => $item['Item']['id'], 'class' => 'item_checkboxs', 'hiddenField' => false)); ?></div></td>
                                <td><?php echo $item['Item']['id']; ?></td>
                                <?php if ($grp_id != 5) { ?>
                                    <td><?php echo $item['Restaurant']['name']; ?></td>
                                <?php } ?>
                                <td><?php echo $item['Category']['name']; ?></td>
                                <td><?php echo $item['Item']['name']; ?></td>
                                <td><?php echo $item['Item']['description']; ?></td>
                                <td><?php echo $item['Item']['price']; ?></td>
                  <!--              <td> <?php
                                if ($item['Item']['is_active'] == 1) {
                                    $st = 'active';
                                    echo $this->Form->postLink('Active', array('action' => 'change_active_status', $item['Item']['id'], $st), array('escape' => false, 'title' => 'Active'), __('Are you sure you want to Active # %s this item?', $item['Item']['id']));
                                } else {
                                    $st = 'inactive';
                                    echo $this->Form->postLink('Inactive', array('action' => 'change_active_status', $item['Item']['id'], $st), array('escape' => false, 'title' => 'Active'), __('Are you sure you want to Unvoid # %s this item?', $item['Item']['id']));
                                }
                                ?>   </td>-->
                                <td class="text-right">                  
                                    <?php if (!empty($item['Suggestion']) && $user_types == 'Admin' && $item['Item']['is_markedasabused'] == 1) {
                                        echo $this->Html->link("View Suggesstion ", '/Suggestions/index/' . $item['Item']['id'], array('escape' => false, 'title' => 'Edit', 'class' => 'btn btn-primary btn-xs'));
                                    } ?>
                                    <?php echo $this->Html->link("Edit Item", '/items/edit/' . $item['Item']['id'], array('escape' => false, 'title' => 'Edit', 'class' => 'btn btn-primary btn-xs')); ?>
                                    <!--<a class="btn btn-default btn-xs" href="#">edit</a>-->
        <?php echo $this->Form->postLink("<i class='icon-remove'></i>", array('action' => 'delete', $item['Item']['id']), array('class' => 'btn btn-danger btn-xs remove-tr', 'escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $item['Item']['name'])); ?>
                                    <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
                                </td>
                            </tr>
    <?php }
} else{ ?><tr><td colspan="7" class="fc-header-center">No Data Found</td></tr><?php }?>
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
