<?php

class Order extends AppModel {

    public $name = 'Order';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),  'Restaurant' => array(
            'className' => 'Restaurant',
            'foreignKey' => 'rest_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),  'RestaurantTable' => array(
            'className' => 'RestaurantTable',
            'foreignKey' => 'table_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),  'UserSetting' => array(
            'className' => 'UserSetting',
            'foreignKey' => false,
            'conditions' => 'Restaurant.user_id = UserSetting.user_id',
            'fields' => '',
            'order' => ''
        ),         
           );
          public $hasMany = array(
        'OrderItem' => array(
            'className' => 'OrderItem',
            'foreignKey' => 'order_id',
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
