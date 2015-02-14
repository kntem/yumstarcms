<script type="text/javascript">
    $(document).ready(function() {
//
//        $("#item_select_all").click(function() {
//        
//            if ($(this).is(":checked")) {
//                $(".item_checkboxs").each(function() {
//                    $(this).prop("checked", true);
//                });
//            }
//            else
//            {
//                $(".item_checkboxs").each(function() {
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
//        $('#suggestion_list').tablePagination(options);
        $("#suggestion_list").tablesorter({headers: {0: {sorter: false}}});
        $("#suggestion_select_all").change(function() {
            if ($(this).is(":checked")) {
                var val1 = 1;
            }
            else
            {
                var val1 = 0;
            }
            if (val1 == 1) {
                $(".suggestion_checkboxs").each(function() {
                    $(this).attr("checked", true);
                });
            }
            else if (val1 == 0) {
                $(".suggestion_checkboxs").each(function() {
                    $(this).removeAttr("checked");
                });
            }
        });
        //bulk delete item.        
        $("#suggestion_delete").click(function() {
            //get ticket ids from checked checkbox's id.
            var suggestion_ids = jQuery('input.suggestion_checkboxs:checkbox:checked').map(function() {
                return this.id;
            }).get();
            //count how many records are selected
            var count = 0;
            $(".suggestion_checkboxs").each(function() {
                if ($(this).is(":checked"))
                {
                    count = count + 1;
                }
            });

            if (suggestion_ids != '') {

                if (confirm('You are about to delete  ' + count + ' records are you sure?'))
                {
//                    alert(jQuery('#SITE_URL').val());


                    $.ajax({//fetch the article via ajax            
                        type: "POST",
                        url: '<?php echo SITE_URL; ?>suggestions/suggestion_builk_delete', //calling this page
                        data: "suggestion_ids=" + suggestion_ids,
                        beforeSend: function() {
                            //jQuery("#indicator").show();
                        },
                        success: function(html) {
                            var response = $.parseJSON(html);
                            if (response.is_deleted == 1) {
                                jQuery('input.suggestion_checkboxs:checkbox:checked').parents("tr").remove();
                                 var rowCount = $('#suggestion_list tr').length;                              
                               if(rowCount == 1){                                
                              $('#suggestion_list > tbody:last').append('<tr><td colspan="7" class="fc-header-center">No Data found</td></tr>');
                               }
                            }
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
          $(".fancybox").fancybox({
            openEffect: 'elastic',
            closeEffect: 'elastic',
            helpers: {
                title: {
                    type: 'inside'
                }
            }
        });
    });
</script>      
<div style="margin-bottom: 20px;">
    <?php echo $this->Form->create('Search', array('class' => 'form-inline row', 'id' => 'item_search', 'style' => 'float:left')); ?>
    <div class="form-group">                               
        <?php echo $this->Form->input('Search.name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    
    </div>
    <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'search')); ?>
    <!--<button class="btn btn-primary" type="submit">Sign in</button>-->
    <?php
    if (isset($flag)) {
        if ($flag == 'true') {

            echo $this->Html->link('View All', '/items', array('class' => 'btn btn-primary'));
        }
    }
    echo $this->Form->end();
    ?>     
    <span class="input-group-btn">
<?php echo $this->Form->button('Delete Selected', array('class' => 'btn btn-danger', 'style' => 'float:right', 'id' => 'suggestion_delete'), __('are u delete?')); ?>
        <!--<button type="button" class="btn btn-primary">Delete All Item</button>-->
    </span>
</div>
<div class="widget widget-blue">
    <div class="widget-title">

        <h3><i class="icon-table"></i> Items</h3>
    </div>
    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="suggestion_list">
                <thead>
                    <tr>
                        <th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'suggestion_select_all')); ?></div></th>
                <th>ID</th>
                <th>User Name</th>
                <th>Item Name</th>
                <th>Comment</th>
                <th>Abused image</th>             
                <th></th>

                </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($suggestions)) {

                        foreach ($suggestions as $suggestion) {
                            ?>
                            <tr>
                                <td><div class="checkbox"><?php echo $this->Form->checkbox('suggestion_id', array('id' => $suggestion['Suggestion']['id'], 'class' => 'suggestion_checkboxs', 'hiddenField' => false)); ?></div></td>
                                <td><?php echo $suggestion['Suggestion']['id']; ?></td>
                                <td><?php echo $suggestion['User']['first_name']; ?></td>
                                <td><?php echo $suggestion['Item']['name']; ?></td>
                                <td><?php echo $suggestion['Suggestion']['suggested_comment']; ?></td>
                                <td><?php
                    if ($suggestion['Suggestion']['suggested_image'] != NULL) {
                        $icon_path = SITE_URL . "suggestion_images/" . $suggestion['Suggestion']['suggested_image'];
                        echo $this->Html->link($this->Html->image($icon_path, array('width' => '50', 'height' => '50')), $icon_path, array('class' => 'fancybox', 'escape' => false, 'data-fancybox-group' => 'button', 'target' => '_blank'));
                    }
                            ?></td>

         <!--<td><span class="label label-success">Active</span></td>-->
                                <td class="text-right">

                                    <!--<a class="btn btn-default btn-xs" href="#">edit</a>-->
        <?php echo $this->Form->postLink("<i class='icon-remove'></i>", array('action' => 'delete', $suggestion['Suggestion']['id']), array('class' => 'btn btn-danger btn-xs remove-tr', 'escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $suggestion['Suggestion']['id'])); ?>
                                    <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
                                </td>
                            </tr>
    <?php }
    }else{ ?><tr><td colspan="7" class="fc-header-center">No Data Found</td></tr><?php }?>
                </tbody>
            </table>
              <div class="pagination_outer pagination pagination-right pagination-mini" id="tablePagination">
                <span id="tablePagination_perPage"><?php
            if(isset($this->params->query['limit'])){
            $limit = $this->params->query['limit'];
//            echo "Limit : ".$limit;
            }
            else{
                $limit=5;
            }
    $options = array( '5' => 5, '10' => 10, '20' => 20 );
 
    echo $this->Form->create(array('type'=>'get'));
 
    echo $this->Form->select('limit', $options,array(
        'value'=>$limit, 
        'default'=>$limit,         
        'onChange'=>'this.form.submit();', 
        'name'=>'limit',
        'id'=>'tablePagination_rowsPerPage',
        'class'=>'per_page span2'
        )
    );
    echo $this->Form->end(); ?>
<!--                    <select class="per_page span2" id="tablePagination_rowsPerPage">
                        <option value="5" selected="">5</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                    </select>-->
                    <span class="per_page">per page</span>                    
                </span>
                <ul id="tablePagination_paginater">                    
                    <li>  <?php echo $this->paginator->first('|< first'); ?> </li>
                    <li>  <?php echo $this->paginator->prev('<< prev', null,null, array('class'=>'prev disabled')); ?> </li>
                    <li>   <?php echo $this->Paginator->numbers(); ?> </li>
                    <li>   <?php echo $this->paginator->next('next >>', null,null, array('class'=>'next disabled')); ?> </li>
                     <li>  <?php echo $this->paginator->last('last >|'); ?> </li>
                     <li><?php echo $this->Paginator->counter(); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
