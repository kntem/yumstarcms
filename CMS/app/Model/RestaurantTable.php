<?php

class RestaurantTable extends AppModel {

    public $name = 'RestaurantTable';
       public $belongsTo = array(
        'Restaurant' => array(
            'className' => 'Restaurant',
            'foreignKey' => 'rest_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
           );
//    public $hasMany = array(
//        'Item' => array(
//            'className' => 'Item',
//            'foreignKey' => 'id',
//            'dependent' => true,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        )
//    );


}

?>
