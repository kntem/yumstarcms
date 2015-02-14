<?php

class Item extends AppModel {

    public $name = 'Item';
public $validate = array(
    'price' => array(
        'rule' => array('decimal', 2),
          'message' => 'Please price in decimal.')
//    ),'category_id' => array(
//        'required' => true
//    ),'rest_id' => array(
//        'required' => true
//    ),'name' => array(
//        'required' => true
//    ), 'description' => array(
//        'required' => true
//    ), 
   
);

    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),'Restaurant' => array(
            'className' => 'Restaurant',
            'foreignKey' => 'rest_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )      
           );
          public $hasMany = array(
        'Suggestion' => array(
            'className' => 'Suggestion',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
}

?>
