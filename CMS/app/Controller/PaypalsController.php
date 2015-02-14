<?php

App::import('Vendor', 'imagetransform');
App::import('Vendor', 'PHPExcel');

class PaypalsController extends AppController {

    var $name = 'Paypals';
//    public $helpers = array('PhpExcel');
    public $components = array('Paginator');
    var $uses = array('Category', 'Item', 'RestItemMapping', 'Restaurant', 'User', 'ItemChoice','Suggestion');
//var $paginate = array(
//        'paramType' => 'querystring',
//        'limit' => 5,
//        'maxLimit' => 1000
//    );
    /**
     * @method index
     * @uses It's use to display all items.
     */
    public function index() {
     

    }

  
}

?>