<script type="text/javascript">
    $(document).ready(function() {
        //for pagination option
        var options = {
            currPage: 1,
            optionsForRows: [15, 25],
            rowsPerPage: 5,
            topNav: false
        }
//        $('#category_list').tablePagination(options); 
        $("#category_list").tablesorter({headers: {0: {sorter: false},7: {sorter: false}}});

        // select all
        $("#category_select_all").click(function() {

            if ($(this).is(":checked")) {
                $(".category_checkboxs").each(function() {
                    $(this).attr("checked", "checked");
                });
            }
            else
            {
                $(".category_checkboxs").each(function() {
                    $(this).removeAttr("checked");
                });
            }
        });
        //bulk delete.        
        $("#category_delete").click(function() {
            //get ids from checked checkbox's id.
            var category_ids = jQuery('input.category_checkboxs:checkbox:checked').map(function() {
                return this.id;
            }).get();
            //count how many records are selected
            var count = 0;
            $(".category_checkboxs").each(function() {
                if ($(this).is(":checked"))
                {
                    count = count + 1;
                }
            });

            if (category_ids != '') {

                if (confirm('You are about to delete  ' + count + ' records are you sure?'))
                {
                    $.ajax({//fetch the article via ajax            
                        type: "POST",
                        url: 'categories/category_builk_delete', //calling this page
                        data: "category_ids=" + category_ids,
                        beforeSend: function() {
                            //jQuery("#indicator").show();
                        },
                        success: function(html) {
                            var response = $.parseJSON(html);                            
                            if (response.is_deleted == 1) {
                                jQuery('input.category_checkboxs:checkbox:checked').parents("tr").remove();
                                var rowCount = $('#category_list tr').length;                              
                               if(rowCount == 1){                                
                              $('#category_list > tbody:last').append('<tr><td colspan="8" class="fc-header-center">No Data found</td></tr>');
                               }

                            }
                        }
                    });
                }
            }
            else
            {
                // if no checkboxes selected
                alert('Please select any category to delete ');
            }
        });
        // for poopup image
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
<?php echo $this->Session->flash(); ?>
<div class="row">
<div style="margin-bottom: 20px;">    
    <div class="row">
        <div class="col-xs-7 col-md-6">
            <?php echo $this->Form->create('Search', array('class' => 'form-inline', 'id' => 'category_search')); ?>
            <div class="form-group col-xs-9">                               
                <?php echo $this->Form->input('Search.name', array('type' => 'text', 'class' => 'form-control', 'label' => false,'placeholder'=>'Category Name')); ?>    
            </div>
            <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success col-xs-2', 'id' => 'search')); ?>
         
        <?php
        if (isset($flag)) {
            if ($flag == 'true') {

                echo $this->Html->link('View All', '/categories', array('class' => 'btn btn-primary'));
            }
        }
        echo $this->Form->end();
        ?>  
              </div>
        <div class="col-xs-5 col-md-6 text-right tab-view">
            <?php echo $this->Html->link('Add New', '/categories/add', array('class' => 'btn btn-primary')); ?>    
            <?php echo $this->Form->button('Delete Selected', array('class' => 'btn btn-danger', 'id' => 'category_delete'), __('are u delete?')); ?>
        </div> 
    </div>        
</div>

<div class="widget widget-blue">
    <div class="widget-title">

        <h3><i class="icon-table"></i> Category </h3>
    </div>
    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="category_list">
                <thead>
                    <tr>
                        <th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'category_select_all')); ?></div></th>
                <th>ID</th>            
                <?php if ($grp_id != 5) { ?>
                    <th>Restaurant Name </th>
                <?php } ?>
                <th>Parent Category Name </th>
                <th>Category Name</th>
                <th>Description</th>
                <th>icon</th>
                <th></th>

                </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            $pid = $category['Category']['parent_id'];
                            if ($category['Category']['id'] == $category['Category']['parent_id']) {
                                $name = $category['Category']['name'];
                            }
                            ?>
                            <tr>
                                <td><div class="checkbox"><?php echo $this->Form->checkbox('category_id', array('id' => $category['Category']['id'], 'class' => 'category_checkboxs', 'hiddenField' => false)); ?></div></td>
                                <td><?php echo $category['Category']['id']; ?></td>
                                <?php if ($grp_id != 5) { ?>
                                    <td><?php echo $category['Restaurant']['name']; ?></td>
                                <?php } ?>
                                <td><?php echo $category['Category1']['name']; ?></td>
                                <td><?php echo $category['Category']['name']; ?></td>
                                <td><?php echo $category['Category']['description']; ?></td>
                                <td><?php
                                    if ($category['Category']['icon'] == NULL) {
                                        $icon_path = SITE_URL . "category_images/place_holder_squre.png";
                                        echo $this->Html->link($this->Html->image($icon_path, array('width' => '50', 'height' => '50')), $icon_path, array('class' => 'fancybox', 'escape' => false, 'data-fancybox-group' => 'button'));
                                    } else {
                                        $icon_path = SITE_URL . "category_images/" . $category['Category']['icon'];
                                        echo $this->Html->link($this->Html->image($icon_path, array('width' => '50', 'height' => '50')), $icon_path, array('class' => 'fancybox', 'escape' => false, 'data-fancybox-group' => 'button'));
                                    }
                                    ?></td>
                                <!--<td><span class="label label-success">Active</span></td>-->
                                <td class="text-right">
                                    <?php echo $this->Html->link("Edit Category", '/categories/edit/' . $category['Category']['id'], array('escape' => false, 'title' => 'Edit Category', 'class' => 'btn btn-primary btn-xs')); 
                                     if (!empty($this->request->query['rest_id'])) {
           echo $this->Html->link("Edit Items", '/Items/index?cat_id=' . $category['Category']['id'], array('escape' => false, 'title' => 'Edit', 'class' => 'btn btn-primary btn-xs')); 
        }?>
                                    
                                    <!--<a class="btn btn-default btn-xs" href="#">edit</a>-->
                                    <?php echo $this->Form->postLink("<i class='icon-remove'></i>", array('action' => 'delete', $category['Category']['id']), array('class' => 'btn btn-danger btn-xs remove-tr', 'escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $category['Category']['name'])); ?>
                                    <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
                                </td>
                            </tr>
                            <?php
                        }
                    }else{
                        ?>
                            <tr><td colspan="8" class="fc-header-center">No Data found</td></tr>
                            <?php
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
</div>