<?php

class Like extends AppModel {
    public $name = 'Like';
    public $belongsTo = array(
        'Suggestion' => array(
            'className' => 'Suggestion',
            'foreignKey' => 'suggestion_id',
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
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => '',
            'conditions' => 'Item.id=Suggestion.item_id',
            'fields' => '',
            'order' => ''
        )
    );
}

?>
