<?php

class OrderItem extends AppModel {

    public $name = 'OrderItem';
    public $belongsTo = array(
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'order_id',
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
        ),
        'ItemChoice' => array(
            'className' => 'ItemChoice',
            'foreignKey' => 'item_choice_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => '',
            'conditions' => 'Category.id = Item.category_id',
            'fields' => '',
            'order' => ''
        )
    );

}

?>
