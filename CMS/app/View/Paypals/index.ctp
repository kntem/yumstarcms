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
?>

<div style="margin-bottom: 20px;">
  <?php  $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
		$paypal_id='tem.narola@narolainfotech.com'; // Business email ID?>
    <!--<button type="button" class="btn btn-primary">Add Restaurant</button>-->
<?php echo $this->Form->create('User', array('url' => $paypal_url)); ?>
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group">                               
            <?php echo $this->Form->hidden('id' ,array('name'=>'action', 'value'=>'createuser')); ?>    
            <?php echo $this->Form->hidden('business' ,array('name'=>'business', 'value'=>$paypal_id)); ?>    
            <?php echo $this->Form->hidden('cmd' ,array('name'=>'cmd', 'value'=>'_xclick')); ?>    
            <?php echo $this->Form->hidden('amount' ,array('name'=>'amount', 'value'=>'10')); ?>    
            <?php echo $this->Form->hidden('currency_code' ,array('name'=>'currency_code', 'value'=>'USD')); ?>    
            <?php echo $this->Form->hidden('handling' ,array('name'=>'handling', 'value'=>'0')); ?>    
            <?php echo $this->Form->hidden('cancel_return' ,array('name'=>'cancel_return', 'value'=>SITE_URL.'paypals/index')); ?>    
            <?php echo $this->Form->hidden('return' ,array('name'=>'return', 'value'=>SITE_URL.'paypals/index')); ?>    
            <?php echo $this->Form->hidden('notify_url' ,array('name'=>'notify_url', 'value'=>SITE_URL.'paypals/index')); ?>    
            <?php echo $this->Form->hidden('rm' ,array('name'=>'rm', 'value'=>2)); ?>    
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
