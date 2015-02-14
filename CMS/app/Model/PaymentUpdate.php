<?php

class PaymentUpdate extends AppModel {

    public $name = 'PaymentUpdate';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )       
           );
 
}

?>
