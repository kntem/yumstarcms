<script type="text/javascript">
    $(document).ready(function() {
        
              var options = {
            currPage: 1,
            optionsForRows: [15, 25],
            rowsPerPage: 5,
            topNav: false
        }
//        $('#restaurantTable_list').tablePagination(options); 
         $("#restaurantTable_list").tablesorter({headers: {0: {sorter: false},4: {sorter: false}}});
                   
        $("#restaurantTable_select_all").click(function() {
         
            if ($(this).is(":checked")) {
                $(".restaurantTable_checkboxs").each(function() {
                    $(this).attr("checked", "checked");
                });
            }
            else
            {
                $(".restaurantTable_checkboxs").each(function() {
                    $(this).removeAttr("checked");
                });
            }
        });
            //bulk delete ticket.        
        $("#restaurantTable_delete").click(function() {
            //get ticket ids from checked checkbox's id.
            var restaurantTable_ids = jQuery('input.restaurantTable_checkboxs:checkbox:checked').map(function() {
                return this.id;
            }).get();
            //count how many records are selected
            var count = 0;
            $(".restaurantTable_checkboxs").each(function() {
                if ($(this).is(":checked"))
                {
                    count = count + 1;
                }
            });

            if (restaurantTable_ids != '') {
               
                if (confirm('You are about to delete  ' + count + ' records are you sure?'))
                { 
//                    alert(jQuery('#SITE_URL').val());


                    $.ajax({//fetch the article via ajax            
                        type: "POST",
                        url: '<?php echo SITE_URL; ?>restaurantTables/restaurantTable_builk_delete', //calling this page
                        data: "restaurantTable_ids=" + restaurantTable_ids,
                        beforeSend: function() {
                            //jQuery("#indicator").show();
                        },
                        success: function(html) {
                            var response = $.parseJSON(html);
                            if (response.is_deleted == 1) {
                                jQuery('input.restaurantTable_checkboxs:checkbox:checked').parents("tr").remove();
                               var rowCount = $('#restaurantTable_list tr').length;                              
                               if(rowCount == 1){                                
                              $('#restaurantTable_list > tbody:last').append('<tr><td colspan="4" class="fc-header-center">No Data found</td></tr>');
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
                alert('Please select any restaurantTable to delete ');
                exit;
            }
        });
        
    });
</script>
<?php 
 

if(isset($this->request->query['sid'])){
    $last=$this->Session->read('last');
     $cnt = count($last);
               
                for($i=0;$i<$cnt;$i++){
    $qid=$last[$i];
    $data=array('Restaurant_id'=>$restid,'Table_id'=>$qid);
//   $codeContents  = 'RestaurantTable_id:'.$restid."\n";
//    $codeContents .= 'table_id:'.$qid;
  $con=json_encode($data);
$this->QrCode->id_qr($con,$qid,$restid); }
}
    

// $this->Session->destroy();
     ?>
      
      <div style="margin-bottom: 20px;">

   <?php echo $this->Form->create('Search', array('class' => 'form-inline', 'id' => 'restaurantTable_search')); ?>
       <div class="row">
        <div class="col-xs-7 col-md-6">
                              <div class="form-group col-xs-9">                               
                                  <?php echo $this->Form->input('Search.name', array('type' => 'text', 'class' => 'form-control', 'label' => false,'placeholder'=>'Table Name')); ?>    
                              </div>
                                <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success','id'=>'search')); ?>
                            
                               <?php 
                                if(isset($flag)) {
         if($flag=='true') {
  
                                echo $this->Html->link('View All', '/restaurantTables', array('class' => 'btn btn-primary')); 
                                }}
                                echo $this->Form->end();
                                ?>
        </div>
           <div class="col-xs-5 col-md-6 text-right">
                            <?php   echo $this->Html->link('Genrate pdf', '/restaurantTables/viewpdf1/'.$restid, array('class' => 'btn btn-warning')); ?>    
       <?php   echo $this->Html->link('Add New', '/restaurantTables/add/'.$restid, array('class' => 'btn btn-primary')); ?>
    
          <?php echo $this->Form->button('Delete Selected', array('class' => 'btn btn-danger','id' => 'restaurantTable_delete'), __('are u delete?'));?>
            
           </div>
                              
      </div>
       </div>
    
<div class="widget widget-blue">
      <div class="widget-title">
            
        <h3><i class="icon-table"></i> <?php echo $restaurantaName." Restaurant's Table List"?> </h3>
      </div>
      <div class="widget-content">
        <div class="table-responsive">
        <table class="table table-bordered table-hover" id="restaurantTable_list">
          <thead>
            <tr>
              <th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'restaurantTable_select_all')); ?></div></th>
              <th>ID</th>
              <!--<th>Restaurant Name</th>-->
              <th>Table Name</th>
              <th>Sequence Id</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
               <?php
              
        if (!empty($restaurantTables)) {
            foreach ($restaurantTables as $restaurantTable) {
               
                ?>
            <tr>
              <td><div class="checkbox"><?php echo $this->Form->checkbox('restaurantTable_id', array('id' => $restaurantTable['RestaurantTable']['id'], 'class' => 'restaurantTable_checkboxs', 'hiddenField' => false)); ?></div></td>
              <td><?php echo $restaurantTable['RestaurantTable']['id']; ?></td>
              <!--<td><?php echo $restaurantTable['Restaurant']['name']; ?></td>-->
              <td><?php echo $restaurantTable['RestaurantTable']['name']; ?></td>
              <td><?php echo $restaurantTable['RestaurantTable']['seq_id']; ?></td>
                        
              <!--<td><span class="label label-success">Active</span></td>-->
              <td class="text-right">
                   <?php // echo $this->Html->link("Table", '/restaurantTable_tables/index/' . $restaurantTable['RestaurantTable']['id'], array('escape' => false, 'title' => 'Table','class'=>'btn btn-default btn-xs'));?>
                  <?php // echo $this->Html->link("Qrcode", array('controller' => 'Qrcodes','action' => 'view', $restaurantTable['RestaurantTable']['id']), array('class' => 'btn btn-default btn-xs', 'target' => '_blank'));?>
                <?php echo $this->Html->link("Edit", '/restaurantTables/edit/' . $restaurantTable['RestaurantTable']['id'], array('escape' => false, 'title' => 'Edit','class'=>'btn btn-default btn-xs'));?>
                <!--<a class="btn btn-default btn-xs" href="#">edit</a>-->
                <?php echo $this->Form->postLink("<i class='icon-remove'></i>", array('action' => 'delete', $restaurantTable['RestaurantTable']['id']), array('class'=>'btn btn-danger btn-xs','escape' => false, 'title' => 'Delete'), __('Are you sure you want to delete # %s?', $restaurantTable['RestaurantTable']['name']));?>
                <!--<a class="btn btn-danger btn-xs remove-tr" href="#"><i class="icon-remove"></i></a>-->
 
              </td>
            </tr>
        <?php }}
        else{
            ?> <tr><td colspan="4" class="fc-header-center">No Data Found</td></tr><?php
        }
        ?>
        <?php // $ar1=array('controller' => 'RestaurantTables', 'action' => 'edit', 2);
//        echo $this->QrCode->url($ar1); ?>
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
  