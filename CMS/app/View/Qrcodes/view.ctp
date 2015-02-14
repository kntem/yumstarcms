
<?php $ar1=array('controller' => 'Qrcodes', 'action' => 'view',$qid);
  
$this->QrCode->url($ar1,$qid); 
//echo $my;
$icon_path = SITE_URL . "qrcode_images/qr1_" . $qid.'.png';
//imagejpeg($my,  WWW_ROOT . 'category_images/mee12.jpg');
echo $this->Html->image($icon_path);
// echo $this->Form->create('Restaurant', array('class' => 'form-horizontal', 'type' => 'file')); 
?>
