<script type="text/javascript">
    $(document).ready(function() {
//        $('#res').bPopup();
//
//        $("#userSetting_select_all").click(function() {
//        
//            if ($(this).is(":checked")) {
//                $(".userSetting_checkboxs").each(function() {
//                    $(this).prop("checked", true);
//                });
//            }
//            else
//            {
//                $(".userSetting_checkboxs").each(function() {
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
             $("#from_date").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: "+1w",
           
        });
       $("#to_date").datepicker({
            dateFormat: "yy-mm-dd",
            defaultDate: "+1w",          
            
        });
//        $('#userSetting_list').tablePagination(options);
        $("#userSetting_list").tablesorter({headers: {0: {sorter: false},6: {sorter: false}}});
      
  $('.btn_report').click(function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: '<?php echo SITE_URL; ?>/restaurants/view_restaurant/' + id,
                type: 'post',
                success: function(response) {
                    $('#modalFormStyle2 .widget-content').html(response);
                    $(document).find('#modalFormStyle2 .widget-content #list').tablePagination(options);
                },
                beforeSend: function() {
                    $('#modalFormStyle2 .widget-content').html('loading');
                },
                error: function() {

                }

            });
            $('#modalFormStyle2').modal();
        });
   
    });


</script>
 
      
      <div style="margin-bottom: 20px;">
           <div class="row">
        
             <?php echo $this->Form->create('Search', array('class' => 'form-inline', 'id' => 'userSetting_search')); ?>
                                                         
                                <?php // echo $this->Form->input('Search.order_date', array('id' => 'order_date', 'type' => 'text', 'class' => 'form-control input-daterangepicker', 'label' => false,'placeholder'=>'Restaurant Name')); ?>
                                  <div class="col-sm-2">
                                <?php echo $this->Form->input('Search.name', array('id' => 'name', 'type' => 'text', 'class' => 'form-control ', 'label' => false,'placeholder'=>'Restaurant Name')); ?>
                                  </div><div class="col-sm-1">                            
                                    
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
                             
                               <?php 
                                if(isset($flag)) {
         if($flag=='true') {
  
                                echo $this->Html->link('View All', '/orderReports/res_report', array('class' => 'btn btn-primary')); 
                                }}
                                echo $this->Form->end();
                                ?>  
     
                              </div></div>
<div class="clearfix"></div>
<div class="widget widget-blue" id="res">
      <div class="widget-title">
           
        <h3><i class="icon-table"></i>Restaurant Balance</h3>
      </div>
      <div class="widget-content">
        <div class="table-responsive">
        <table class="table table-bordered table-hover" id="userSetting_list">
          <thead>
            <tr>
              <!--<th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'userSetting_select_all')); ?></div></th>-->
              <th>ID</th>
              <th>Restaurant Name</th>
              <th>User Name</th>                           
              <th>Revenue</th>
              <th>Order Amount</th> 
              <th>Percentage</th>              
              <th></th>
             </tr>
          </thead>
          <tbody>
               <?php     
              $total=array();
               $total['bus_total'] = 0;
                 $total['com_total'] = 0;
                 $total['final_total'] = 0;
        if (!empty($res_ords)) {          
            foreach ($res_ords as $res_ords) {               
                
                               ?>
            <tr id="row_<?php echo $res_ords['Restaurant']['id']; ?>">
              <!--<td><div class="checkbox"><?php echo $this->Form->checkbox('userSetting_id', array('id' => $res_ords['Restaurant']['id'], 'class' => 'user_checkboxs', 'hiddenField' => false)); ?></div></td>-->
              <td><?php echo $res_ords['Restaurant']['id']; ?></td>              
              <td><?php echo $res_ords['Restaurant']['name']; ?></td>   
              <td><?php echo $res_ords['User1']['username']; ?></td>   
             
            <?php $total['com']= $res_ords['Order']['total_cum']; ?>
              <td><?php echo $this->Number->currency($res_ords['Order']['total_cum'],'EUR'); ?></td>
               <td><?php echo  $this->Number->currency($res_ords['Order']['total_order'],'EUR');
             $total['bus'] = $res_ords['Order']['total_order']; ?>    </td>
<!--              <td><?php  $total['final'] = $total['bus'] - $total['com'];
            echo   $this->Number->currency($total['final'],'EUR');
              ?></td>-->
              <td><?php echo $this->Number->currency($res_ords['UserSetting']['bill_rate'],'EUR').'%'; ?></td>
              <td>  <?php echo $this->Html->link("View User",'/viewUser/' . $res_ords['User1']['id'], array('escape' => false, 'title' => 'Report','class'=>'btn btn-primary btn-xs'));?>
  <div class="btn btn-primary btn-xs btn_report" data-toggle="modal" data-target="#modalFormStyle2" data-id="<?php echo $res_ords['Restaurant']['id'] ?>">View business</div>
                  <?php echo $this->Html->link("View statistics", '/OrderReports/item_stat/' . $res_ords['Restaurant']['id'], array('escape' => false, 'title' => 'Report','class'=>'btn btn-primary btn-xs'));?></td>
           
            </tr>
                 <?php 
                 $total['bus_total'] += $total['bus'];
                 $total['com_total'] += $total['com'];
                 $total['final_total'] += $total['final'];
            }?>
               <tr>
                <td></td>
                <td></td>
                <td style="text-align:right;"><b>Total:</b></td>              
                <td><?php echo $this->Number->currency($total['com_total'],'EUR'); ?></td>
                  <td><?php echo $this->Number->currency($total['bus_total'],'EUR'); ?></td>
                <td><?php // echo $this->Number->currency($total['final_total'],'USD'); ?></td>
                <td></td>
                
            </tr>
           <?php }
            else{?>
            <tr><td colspan="7" class="fc-header-center">No data Found</td></tr>
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
        <div class="modal fade" id="modalFormStyle2" tabindex="-1" role="dialog" aria-labelledby="modalFormStyle2Label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="widget widget-blue">
                        <div class="widget-title">
                          <div class="widget-controls">
 <a href="#"  class="widget-control" data-original-title="Remove" data-dismiss="modal"><i class="icon-remove-sign"></i></a>
</div>
                          <h3><i class="icon-ok-sign"></i> Restaurant information</h3>
                        </div>
                        <div class="widget-content">
                     
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
        </div>
<div class="paynow"><?php 
 $today = date('Y-m-d');
        $payment_date = date('Y-m-01');
if(!empty($payment) && (empty($paybtn))) { 
    echo 'Your Monthly Payment ' .$this->Number->currency($payment['Order']['total_cum'],'EUR'). ' of '.$last_mon .' month';
?>
     <?php echo $this->Form->create('OrderReports', array('action' => 'exp_check')); ?>
    <?php echo $this->Form->button('Pay Now', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'paypal'));
echo $this->Form->end(); }?>
</div>