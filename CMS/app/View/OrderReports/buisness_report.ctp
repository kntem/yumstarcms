<script type="text/javascript">
    $(document).ready(function() {

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
        $(document).find('#modalFormStyle2 .widget-content #list').tablePagination(options);
        $("#userSetting_list").tablesorter({headers: {0: {sorter: false}, 5: {sorter: false}}});

        $('.btn_report').click(function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: '<?php echo SITE_URL; ?>/OrderReports/restaurant_report/' + id,
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
    <?php echo $this->Form->create('Search', array('class' => 'form-inline', 'id' => 'userSetting_search')); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">                               
                <?php echo $this->Form->input('Search.order_date', array('id' => 'order_date', 'type' => 'text', 'class' => 'form-control input-daterangepicker', 'label' => false, 'placeholder' => 'Date')); ?>
            </div>
            <?php echo $this->Form->button('Search', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'search')); ?>
            <!--<button class="btn btn-primary" type="submit">Sign in</button>-->
            <?php
            if (isset($flag)) {
                if ($flag == 'true') {

                    echo $this->Html->link('View All', '/userSettings', array('class' => 'btn btn-primary'));
                }
            }
            echo $this->Form->end();
            ?>  
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="widget widget-blue">
    <div class="widget-title">

        <h3><i class="icon-table"></i>Business Balance</h3>
    </div>
    <div class="widget-content">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="userSetting_list">
                <thead>
                    <tr>
                      <!--<th><div class="checkbox"><?php echo $this->Form->checkbox('select_all', array('id' => 'userSetting_select_all')); ?></div></th>-->
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Business Total</th>              
                        <th>Total Commission</th>
                        <th>Total</th>              
                        <th>Report</th>              
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_com = 0;
                    $total_bui = 0;
                    $total = 0;
                    $total_com_tr = 0;
                    $total_bui_tr = 0;
                    $total_tr = 0;
                    if (!empty($users)) {
                        foreach ($users as $user) {
                            ?>
                            <tr id="row_<?php echo $user['User']['id']; ?>">
                              <!--<td><div class="checkbox"><?php echo $this->Form->checkbox('userSetting_id', array('id' => $user['User']['id'], 'class' => 'user_checkboxs', 'hiddenField' => false)); ?></div></td>-->
                                <td><?php echo $user['User']['id']; ?></td>              
                                <td><?php echo $user['User']['username']; ?></td>   
                                <td class="tot_bu"><?php
                                    foreach ($orderItems as $orderItem) {
                                        if ($orderItem['UserSetting']['user_id'] == $user['User']['id']) {
                                            $total_com = $total_com + $orderItem[0]['total_cum'];
                                            $total_bui = $total_bui + $orderItem[0]['total'];
                                            $total = $total_bui - $total_com;
                                        }
                                    }
                                    $total_com_tr = $total_com_tr + $total_com;
                                    $total_bui_tr = $total_bui_tr + $total_bui;
                                    $total_tr = $total_tr + $total;
                                    echo $this->Number->currency($total_bui, 'USD');
                                    ?></td>
                                <td><?php echo $this->Number->currency($total_com, 'USD'); ?></td>
                                <td><?php echo $this->Number->currency($total, 'USD'); ?></td>

                                <td> <div class="btn btn-primary btn_report" data-toggle="modal"  data-id="<?php echo $user['User']['id'] ?>">Report</div> <?php // echo $this->Html->link("Report", '/OrderReports/restaurant_report/' . $user['User']['id'], array('escape' => false, 'title' => 'Report', 'class' => 'btn btn-default btn-xs',''));     ?></td>
                                <?php
                                $total_com = 0;
                                $total = 0;
                                $total_bui = 0;
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td class="fc-header-right"><b>Total:</b></td>

                            <td><?php echo $this->Number->currency($total_bui_tr, 'USD'); ?></td>
                            <td><?php echo $this->Number->currency($total_com_tr, 'USD'); ?></td>
                            <td><?php echo $this->Number->currency($total_tr, 'USD'); ?></td>
                            <td></td>
                        </tr>
                    <?php } else {
                        ?> <tr><td colspan="4" class="fc-header-center">No Data Found</td></tr>
                        <?php }
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


<div class="modal fade" id="modalFormStyle2" tabindex="-1" role="dialog" aria-labelledby="modalFormStyle2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="widget widget-blue" id="res">
                <div class="widget-title">
                    <div class="widget-controls">

                        <a href="#"  class="widget-control" data-original-title="Remove" data-dismiss="modal"><i class="icon-remove-sign"></i></a>
                    </div>
                    <h3><i class="icon-table"></i>Restaurant Balance</h3>
                </div>

                <div class="widget-content">
              
                </div>
            </div>
        </div>
    </div>
</div>

