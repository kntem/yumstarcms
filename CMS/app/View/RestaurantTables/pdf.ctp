<?php
//pr($restaurant_table);
$data1='';
  if (!empty($restaurant_table)) {
            foreach ($restaurant_table as $restaurantTable) {
                $icon_path = SITE_URL . "qrcode_images/".$restaurantTable['Restaurant']['id']."/". $restaurantTable['RestaurantTable']['qrcode'];
//                                    echo $this->Html->image($icon_path, array('width' => '50', 'height' => '50'));
                                
              $fpdf->Image($icon_path,10,10,-300);
               
  }}
$fpdf->AddPage();
    $fpdf->SetFont('Arial','B',16);
    
    
    $fpdf->Cell(40,10,$data1);
    $fpdf->Output();
?>

