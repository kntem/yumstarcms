<?php

class Restaurant extends AppModel {

    public $name = 'Restaurant';
    public $validate = array(
    'name' => array(
        'required' => true
    ), 'address' => array(
        'required' => true
    ), 'area' => array(
        'required' => true
    ), 'city' => array(
        'required' => true
    ) ,'email' => array(
        'rule' => 'email',
        'required' => true
    ),'contact_no' => array(
        'rule' => 'numeric',
        'required' => true,
        'message'=>'Please fill numeric field'
    )
);

   public $hasMany = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'rest_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'rest_id',
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
