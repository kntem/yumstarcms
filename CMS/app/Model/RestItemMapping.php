<?php

class RestItemMapping extends AppModel {

    public $name = 'RestItemMapping';
    public $belongsTo = array(
        'Restaurant' => array(
            'className' => 'Restaurant',
            'foreignKey' => 'rest_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'item_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
        
           );

}

?>
