<?php

App::import('Vendor', 'imagetransform');
App::import('Vendor', 'PHPExcel');

class OrderItemsController extends AppController {

    var $name = 'OrderItems';
//    public $helpers = array('PhpExcel');
    public $components = array('Paginator');
    var $uses = array('OrderItem', 'Item', 'Restaurant', 'Qrcode', 'User', 'Category','RestaurantTable','Order');
var $paginate = array(
        'paramType' => 'querystring',
        'limit' => 5,
        'maxLimit' => 1000,
     'fields' => array('Category.*', 'Order.*', 'ItemChoice.*', 'Item.*', 'OrderItem.*')
//            'joins' => array(
//                array(
//                    'table' => 'categories',
//                    'alias' => 'Category',
//                    'type' => 'inner',
//                    'foreignKey' => false,
//                    'conditions' => array('Category.id = Item.category_id')))
    );
    /**
     * @method index
     * @uses It's use to display all tickets.
     */
    public function index($id) {
        $user_type = $this->UserAuth->getUser();
        $user_type = $user_type['UserGroup']['name'];
        $this->set('title_for_layout', 'OrderItem');
        $user_id = $this->UserAuth->getUserId();
        $conditions = array();
//             if($user_type != 'Admin'){
        $conditions[] = array('AND' => array('OrderItem.order_id =' => $id, 'OrderItem.status =' => 1));
//            }
        if (($this->request->is('post')) || ($this->request->is('put'))) {
            if (!empty($this->request->data['Search']['item_name'])) {
                $conditions[] = array('OR' => array('Item.name LIKE' => '%' . $this->request->data['Search']['item_name'] . '%'));
            }
            if (!empty($this->request->data['Search']['category_name'])) {
                $conditions[] = array('OR' => array('Category.name LIKE' => '%' . $this->request->data['Search']['category_name'] . '%'));
            }
            if (!empty($this->request->data['Search']['item_choice'])) {
                $conditions[] = array('OR' => array('ItemChoice.choice_name LIKE' => '%' . $this->request->data['Search']['item_choice'] . '%'));
            }
            $this->set('flag', 'true');
            $this->set('id', $id);
            //pr($conditions);
        }
//        $orderItem = $this->OrderItem->find('all', array(
//            'conditions' => $conditions));
//        $orderItem = $this->OrderItem->find('all', array(
//            'fields' => array('Category.*', 'Order.*', 'ItemChoice.*', 'Item.*', 'OrderItem.*'),
//            'joins' => array(
//                array(
//                    'table' => 'categories',
//                    'alias' => 'Category',
//                    'type' => 'inner',
//                    'foreignKey' => false,
//                    'conditions' => array('Category.id = Item.category_id')
//                )
//            ),
//            'conditions' => $conditions));
  $this->Paginator->settings = $this->paginate;
     $orderItem = $this->Paginator->paginate('OrderItem',$conditions);
//     pr($orderItem);
//    $this->set('orders', $order);
        $this->set('orderItems', $orderItem);
    }

    /**
     * @method delete
     * @param integer $orderItem_id
     * @return void
     */
    public function delete($orderItem_id = null) {
        $this->set('title_for_layout', 'orderItem delete');
        $user_id = $this->UserAuth->getUserId();
        $this->OrderItem->id = $orderItem_id;
        if ($this->OrderItem->exists()) {
            if ($this->OrderItem->delete($orderItem_id)) {
                $this->Session->setFlash(__('OrderItem has successfully deleted.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('OrderItem not deleted. please, try an again.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->Session->setFlash(__('OrderItem has not found.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * @method orderItem_builk_delete
     * @return boolean
     * @uses It's use to delete multiple orderItems.
     */
    public function orderItem_builk_delete() {
        $this->layout = 'ajax';

        $orderItem_ids = $this->request->data['orderItem_ids'];
        $response = array();
        if (!empty($orderItem_ids)) {
            $orderItem_id_array = explode(',', $orderItem_ids);
            foreach ($orderItem_id_array as $orderItem_id) {
                //check orderItem is exist or not.
                $this->OrderItem->id = $orderItem_id;
                if ($this->OrderItem->exists()) {
                    $this->OrderItem->saveField('status', 0);
                }
            }
            $response = array('is_deleted' => 1);
        } else {
            $response = array('is_deleted' => 0);
        }
        echo json_encode($response);
        exit;
    }

    /**
     * @method change_active_status
     * @uses It's use to change active status.
     * @param int $item_id,varchar $st.
     */
    public function change_status($orderItem_id = null, $st, $cn) {
        $this->OrderItem->id = $orderItem_id;
        $orderItem = $this->OrderItem->findById($orderItem_id);
//        pr($orderItem);
//        exit();
        $total_amt=$orderItem['Order']['total_amount'];
        $amt=$orderItem['Item']['price'];
        $id=$orderItem['Order']['id'];
      
        $final=$total_amt-$amt;
        if ($this->OrderItem->exists()) {
            if ($st == 0) {
                $this->OrderItem->saveField('status', 0);
                    $this->Order->id=$orderItem['OrderItem']['order_id'];
                $this->Order->saveField('total_amount', $final);
            } else if ($st == 2) {
                 
                $this->OrderItem->saveField('status', 2);
                $items=  $this->OrderItem->find('all',array(
            'conditions'=>array('AND'=>array('OrderItem.Order_id'=>$id,'OrderItem.status <>'=>2))
        ));
//      pr($items);
//      exit();
  if(empty($items)){
//      exit();
      $this->change_status1($id);
       
  }
            
            }
            if ($cn == 'my') {
                $this->redirect(array('action' => 'running_item_index'));
            } else {
                $this->redirect(array('action' => 'index', $orderItem['OrderItem']['order_id']));
            }
        } else {

            $this->Session->setFlash(__('OrderItem not found.'));
            if ($cn == 'my') {
                $this->redirect(array('action' => 'running_item_index'));
            } else {
                $this->redirect(array('action' => 'index', $orderItem['OrderItem']['order_id']));
            }
        }
    }
  public function change_status1($order_id) {
//        echo 'hii';
//        exit();
        $this->Order->id = $order_id;
//        $orderItem = $this->Order->findById($order_id);
        if ($this->Order->exists()) {
           
                $this->Order->saveField('status', 2);
          $this->redirect(array('action' => 'running_item_index'));
        }
    }
    public function running_item_index() {
        $user_type = $this->UserAuth->getUser();
        $user_type1 = $user_type['UserGroup']['name'];
        $user_grp_id = $user_type['UserGroup']['id'];
        $this->set('title_for_layout', 'OrderItem');
        $user_id = $this->UserAuth->getUserId();
        $rest_id = $this->User->findById($user_id);
        $conditions = array();
        if ($user_grp_id == 5) {
            $conditions[] = array('AND' => array('Order.rest_id =' => $rest_id['User']['rest_id'], 'OrderItem.status ' => 1));
        }
        if (($this->request->is('post')) || ($this->request->is('put'))) {
            if (!empty($this->request->data['Search']['table_name'])) {
                $conditions[] = array('OR' => array('RestaurantTable.id ' =>  $this->request->data['Search']['table_name'] ));
            }
            if (!empty($this->request->data['Search']['ite_name'])) {
                $conditions[] = array('OR' => array('Item.name LIKE' => '%' . $this->request->data['Search']['item_name'] . '%'));
            }
            if (!empty($this->request->data['Search']['category_name'])) {
                $conditions[] = array('OR' => array('Category.name LIKE' => '%' . $this->request->data['Search']['category_name'] . '%'));
            }
            if (!empty($this->request->data['Search']['item_choice'])) {
                $conditions[] = array('OR' => array('ItemChoice.choice_name LIKE' => '%' . $this->request->data['Search']['item_choice'] . '%'));
            }
            $this->set('flag', 'true');
           
        }
        $orderItem = $this->OrderItem->find('all', array(
            'fields' => array('Category.*', 'Order.*', 'ItemChoice.*', 'Item.*', 'OrderItem.*', 'RestaurantTable.*'),
            'joins' => array(
//                array(
//                    'table' => 'categories',
//                    'alias' => 'Category',
//                    'type' => 'inner',
//                    'foreignKey' => false,
//                    'conditions' => array('Category.id = Item.category_id')
//                ),
                array(
                    'table' => 'restaurant_tables',
                    'alias' => 'RestaurantTable',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('RestaurantTable.id = Order.table_id')
                )
            ),
            'conditions' => $conditions));
        $this->set('orderItems', $orderItem);
        $item = $this->Item->find('list', array(
            'fields' => array('Item.id', 'Item.name'),
            'conditions' => array('Item.rest_id' => $rest_id['User']['rest_id'])
        ));
        $this->set('items', $item);
        $table = $this->RestaurantTable->find('list', array(
            'fields' => array('RestaurantTable.id', 'RestaurantTable.name'),
            'conditions' => array('RestaurantTable.rest_id' => $rest_id['User']['rest_id'])
        ));
        $this->set('tables', $table);
        $category = $this->Category->find('list', array(
            'fields' => array('Category.id', 'Category.name'),
            'conditions' => array('Category.rest_id' => $rest_id['User']['rest_id'])
        ));
        $this->set('categories', $category);
    }

    public function item_report() {
        $user_type = $this->UserAuth->getUser();
        $user_type1 = $user_type['UserGroup']['name'];
        $user_grp_id = $user_type['UserGroup']['id'];
        $this->set('title_for_layout', 'OrderItem');
        $user_id = $this->UserAuth->getUserId();
        $rest_id = $this->User->findById($user_id);
        $conditions = array();
//        if($user_grp_id == 5){
//         $conditions[] = array('AND' => array('Order.rest_id =' => $rest_id['User']['rest_id'],'OrderItem.status ' => 1));
//        }
        if (($this->request->is('post')) || ($this->request->is('put'))) {
            if (!empty($this->request->data['Search']['table_name'])) {
                $conditions[] = array('OR' => array('RestaurantTable.name LIKE' => '%' . $this->request->data['Search']['table_name'] . '%'));
            }
            if (!empty($this->request->data['Search']['ite_name'])) {
                $conditions[] = array('OR' => array('Item.name LIKE' => '%' . $this->request->data['Search']['item_name'] . '%'));
            }
            if (!empty($this->request->data['Search']['category_name'])) {
                $conditions[] = array('OR' => array('Category.name LIKE' => '%' . $this->request->data['Search']['category_name'] . '%'));
            }
            if (!empty($this->request->data['Search']['item_choice'])) {
                $conditions[] = array('OR' => array('ItemChoice.choice_name LIKE' => '%' . $this->request->data['Search']['item_choice'] . '%'));
            }
            $this->set('flag', 'true');
            $this->set('id', $id);
        }
        $orderItem = $this->OrderItem->find('all', array(
            'fields' => array('Category.*', 'Order.*', 'ItemChoice.*', 'Item.*', 'OrderItem.*', 'RestaurantTable.*', 'User.*', 'Restaurant.*'),
            'joins' => array(
                array(
                    'table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('Category.id = Item.category_id')
                ), array(
                    'table' => 'restaurant_tables',
                    'alias' => 'RestaurantTable',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('RestaurantTable.id = Order.table_id')
                ), array(
                    'table' => 'restaurants',
                    'alias' => 'Restaurant',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('Order.rest_id = Restaurant.id')
                ), array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'foreignKey' => false,
                    'conditions' => array('User.id = Order.user_id')
                )
            ),
        ));
        $this->set('orderItems', $orderItem);
    }

}

?>