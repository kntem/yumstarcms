<script type="text/javascript">
    $(document).ready(function() {


    });
</script>
<?php
// if(isset($this->request->query['qid'])){
//    $qid=$this->request->query['qid'];
//   $codeContents  = 'Restaurant_id:'.$qid."\n";
//    $codeContents .= 'table_id:1';
//  
//$this->QrCode->id_qr($codeContents,$qid); } 
//pr($order);
?>

<div style="margin-bottom: 20px;">
  <?php  $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
		$paypal_id='suv.narola@narolainfotech.com'; // Business email ID?>
    <!--<button type="button" class="btn btn-primary">Add Restaurant</button>-->
<?php echo $this->Form->create('User', array('url' => $paypal_url)); ?>
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">                               
            <?php echo $this->Form->hidden('id' ,array('name'=>'action', 'value'=>'createuser')); ?>    
            <?php echo $this->Form->hidden('business' ,array('name'=>'business', 'value'=>$paypal_id)); ?>    
            <?php echo $this->Form->hidden('cmd' ,array('name'=>'cmd', 'value'=>'_xclick')); ?>    
            <?php echo $this->Form->hidden('amount' ,array('name'=>'amount', 'value'=>'10')); ?>    
            <?php // echo $this->Form->hidden('amount' ,array('name'=>'amount', 'value'=>intval($order['Order']['total_cum']))); ?>    
            <?php echo $this->Form->hidden('currency_code' ,array('name'=>'currency_code', 'value'=>'USD')); ?>    
            <?php echo $this->Form->hidden('handling' ,array('name'=>'handling', 'value'=>'0')); ?>    
            <?php echo $this->Form->hidden('cancel_return' ,array('name'=>'cancel_return', 'value'=>SITE_URL.'OrderReports/cancel')); ?>    
            <?php echo $this->Form->hidden('return' ,array('name'=>'return', 'value'=>SITE_URL.'OrderReports/return_data')); ?>    
            <?php echo $this->Form->hidden('notify_url' ,array('name'=>'notify_url', 'value'=>SITE_URL.'OrderReports/notify')); ?>    
            <?php // echo $this->Form->hidden('rm' ,array('name'=>'rm', 'value'=>2)); ?>    
            <?php // echo $this->Form->hidden('notify_url' ,array('name'=>'notify_url', 'value'=>SITE_URL.'paypals/index')); ?>    
            </div>
            <?php echo $this->Form->button('Pay Now', array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'search')); ?>
            <?php
            if (isset($flag)) {
                if ($flag == 'true') {

                    echo $this->Html->link('View All', '/restaurants', array('class' => 'btn btn-primary'));
                }
            }
            echo $this->Form->end();
            ?>
        </div>  

        <div class="col-sm-4 text-right">


        </div>
    </div>
</div>
<?php // pr($_POST); ?>
<!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="ps.narola@narolainfotech.com" >
<input type="hidden" name="item_name" value="Union Jack Flag">
<input type="hidden" name="amount" value="20">
<input type="hidden" name="currency_code" value="EUR">
<input type="hidden" name="undefined_quantity" value="1">
<input type="hidden" name="return" value="<?php echo SITE_URL.'OrderReports/paypal_index';?>">
<input type="hidden" name="cancel_return" value="<?php echo SITE_URL.'OrderReports/paypal_index';?>">
<input type="hidden" name="notify_url" value="<?php echo SITE_URL.'OrderReports/notify';?>">
<input type="image" src="https://www.paypal.com/en_GB/i/btn/x-click-butcc.gif" border="0" name="submit" width="73" height="44">
</form>-->
