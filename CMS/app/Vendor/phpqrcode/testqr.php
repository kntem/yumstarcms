<?php

include "qrlib.php";
 //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

       
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
		
$backColor = 0xFFFF00;
$foreColor = 0xFF00FF;
 
$img= time();
 //$filename = $PNG_TEMP_DIR.$img.".png";
 $filename = $PNG_TEMP_DIR."testing.png";
// $img="test122.png";
// Create a QR Code and export to SVG
QRcode::png($img,$filename,"H",1,10,false,$backColor,$foreColor);

//  for image as input

// here our data
    $name = 'John Doe';
    $phone = '1';
    
    // WARNING! here jpeg file is only 40x40, grayscale, 50% quality!
    // with bigger images it will simply be TOO MUCH DATA for QR Code to handle!
    
    $avatarJpegFileName = 'authnet.png';
    
    // we building raw data
    $codeContents  = 'BEGIN:VCARD'."\n";
    $codeContents .= 'FN:'.$name."\n";
    $codeContents .= 'TEL;WORK;VOICE:'.$phone."\n";
   // $codeContents .= 'PHOTO;JPEG;ENCODING=BASE64:'.base64_encode(file_get_contents($avatarJpegFileName))."\n";
    $codeContents .= 'END:VCARD';
    
    // generating
    QRcode::png($codeContents, $PNG_TEMP_DIR.'029.png', "L", 3);
   
    // displaying
    echo '<img src="temp/029.png" />'; 


?>