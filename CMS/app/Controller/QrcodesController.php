<?php

App::import('Vendor', 'imagetransform');
App::import('Vendor', 'PHPExcel');
App::import('Helper', 'QrCode');
App::import('Vendor', 'phpqrcode'.DS.'qrlib');
class QrcodesController extends AppController {

    var $name = 'Qrcodes';
    public $helpers = array('QrCode');
    public $components = array();
var $uses = array('Category','Item','Restaurant');

    /**
     * @method index
     * @uses It's use to display all Restaurants.
     */
    public function view($id) {
        $this->layout='ajax';
           $this->set('qid',$id);
//           $this->redirect(array('controller' => 'Restaurants', 'action' => 'index'));
//echo $this->QrCode->text($id);
          
       
    }
  
}
?>