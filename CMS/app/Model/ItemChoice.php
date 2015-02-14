<?php

class ItemChoice extends AppModel {

    public $name = 'ItemChoice';    

    public $belongsTo = array(
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'item_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ));
        
}

?>
