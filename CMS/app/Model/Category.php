<?php

class Category extends AppModel {
    
    public $name = 'Category';

       public $belongsTo = array(
        'Category1' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),'Restaurant' => array(
            'className' => 'Restaurant',
            'foreignKey' => 'rest_id',
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
        ),
           );
    public $hasMany = array(
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'category_id',
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
         'sub_category' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id',
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
