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
//        $('#item_list').tablePagination(options);
//        $("#item_list").tablesorter({headers: {0: {sorter: false}}});
        $("#item_select_all").change(function() {        
            if ($(this).is(":checked")) {
                var val1 = 1;               
            }
            else
            {
                var val1 = 0;               
            }
            if(val1 == 1){
                 $(".item_checkboxs").each(function() {
                    $(this).attr("checked", true);
                });
            }
            else if(val1 == 0){
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
                                jQuery('input.item_checkboxs:checkbox:checked').parents("tr").remove();
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
                alert('Please select any item to delete ');
            }
        });
        
    });
</script>
 
      
      <div style="margin-bottom: 20px;">
             <?php echo $this->Form->create('Search', array('class' => 'form-inline row', 'id' => 'item_search','style'=>'float:left')); ?>
                              <div class="form-group">                               
                                  <?php echo $this->Form->input('Search.name', array('type' => 'text', 'class' => 'form-control', 'label' => false)); ?>    
                              </div>
                                <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success','id'=>'search')); ?>
                              <!--<button class="btn btn-primary" type="submit">Sign in</button>-->
                               <?php 
                                if(isset($flag)) {
         if($flag=='true') {
  
                                echo $this->Html->link('View All', '/items', array('class' => 'btn btn-primary')); 
                                }}
                                echo $this->Form->end();
                                ?>
      <!--<button type="button" class="btn btn-primary">Add Item</button>-->
       <?php   echo $this->Html->link('Add New', '/items/add', array('class' => 'btn btn-primary', 'style' => 'float:right')); ?>
      <span class="input-group-btn">
          <?php echo $this->Form->button('Delete Selected', array('class' => 'btn btn-danger','style' => 'float:right', 'id' => 'item_delete'), __('are u delete?'));?>
                <!--<button type="button" class="btn btn-primary">Delete All Item</button>-->
              </span>
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
               <?php if($grp_id != 5) {?>
              <th>Restaurant Name </th>
              <?php } ?>
              <th>Category Name</th>
              <th>Item Name</th>
              <th>Description</th>
              <th>price</th>
              <th>Active</th>
                           <th></th>
              
            </tr>
          </thead>
          <tbody>
               <?php
              
        if (!empty($items)) {
            pr($items);
            exit();
           foreach ($items as $item) {               
                               ?>
            <tr>
              <td><div class="checkbox"><?php echo $this->Form->checkbox('item_id', array('id' => $item['Item']['id'], 'class' => 'item_checkboxs', 'hiddenField' => false)); ?></div></td>
              <td><?php echo $item['Item']['id']; ?></td>
               <?php if($grp_id != 5) {?>
              <td><?php echo $item['Restaurant']['name']; ?></td>
              <?php } ?>
              <td><?php echo $item['Category']['name']; ?></td>
              <td><?php echo $item['Item']['name']; ?></td>
              <td><?php echo $item['Item']['description']; ?></td>
              <td><?php echo $item['Item']['price']; ?></td>
              <td> <?php
                        if ($item['Item']['is_active'] == 1) {
                            $st = 'active';
                            echo $this->Form->postLink('Active', array('action' => 'change_active_status', $item['Item']['id'], $st), array('escape' => false, 'title' => 'Active'), __('Are you sure you want to Active # %s this item?', $item['Item']['id']));
                        } else {
                            $st = 'inactive';
                            echo $this->Form->postLink('Inactive', array('action' => 'change_active_status', $item['Item']['id'], $st), array('escape' => false, 'title' => 'Active'), __('Are you sure you want to Unvoid # %s this item?', $item['Item']['id']));
                        }
                        ?>   </td>
              <td class="text-right">                  
                  <?php              
                          if(!empty($item['Suggestion']) && $user_types == 'Admin' && $item['Item']['is_markedasabused']==1){echo $this->Html->link("View Suggesstion ", '/Suggestions/index/' . $item['Item']['id'], array('escape' => false, 'title' => 'Edit','class'=>'btn btn-default btn-xs'));}?>
                <?php echo $this->Html->link("Edit", '/items/edit/' . $item['Item']['id'], array('escape' => false, 'title' => 'Edit','class'=>'btn btn-default btn-xs'));?>
                <!--<a class="btn btn-default btn-xs" href="#">edit</a>-->
                <?php echo $this->Form->postLink("<i class='icon-remove'></i>", array('action' => 'delete', $item['Item']['id']), array('class'=>'btn btn-danger btn-xs remove-tr','escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $item['Item']['name']));?>
                <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
              </td>
            </tr>
        <?php }}?>
          </tbody>
        </table>
               
             <?php // echo $this->Paginator->prev('« Previous'); ?>
    <?php echo $this->Paginator->prev(
  ' << ' . __('previous'),
  array(),
  null,
  array('class' => 'prev disabled')
);?>    
             <?php echo $this->Paginator->numbers(); ?>
             <?php echo $this->Paginator->next(
  ' >> ' . __('next'),
  array(),
  null,
  array('class' => 'next disabled')
);?>   
    <?php echo $this->Paginator->counter(); ?>
        </div>
      </div>
    </div>
  