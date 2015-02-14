<?php

App::import('Vendor', 'imagetransform');
App::import('Vendor', 'PHPExcel');

class CategoriesController extends AppController {

    var $name = 'Categories';
//    public $helpers = array('PhpExcel');
    public $components = array('Paginator');
    var $uses = array('Category', 'Item', 'Restaurant', 'Qrcode', 'User');
var $paginate = array(
        'paramType' => 'querystring',
        'limit' => 5,
        'maxLimit' => 1000
    );
    /**
     * @method index
     * @uses It's use to display all tickets.
     */
    public function index() {
        $user = $this->UserAuth->getUser();
        $user_type = $user['UserGroup']['name'];
        $grp_id = $user['UserGroup']['id'];
        $this->set('title_for_layout', 'Category');
        $user_id = $this->UserAuth->getUserId();
        $rest_id = $this->User->findById($user_id);

//        pr($rest_id);
//        exit();

        $conditions = array();

        if ($user_type != 'Admin') {
            if ($grp_id == '5') {
//                echo $rest_id['User']['rest_id'];
            $conditions[] = array('OR' => array('Category.rest_id =' => $rest_id['User']['rest_id']));
            } else {
                $conditions[] = array('OR' => array('Category.user_id =' => $user_id));
            }
//         $conditions[] = array('OR' => array('Category.rest_id =' => $rest_id['User']['rest_id']));
         
        }
        if (!empty($this->request->query['rest_id'])) {
              $conditions[] = array('OR' => array('Category.rest_id =' => $this->request->query['rest_id']));
        }
        
        if (($this->request->is('post')) || ($this->request->is('put'))) {


            if (!empty($this->request->data['Search']['name'])) {
                $conditions[] = array('OR' => array('Category.name LIKE' => '%' . $this->request->data['Search']['name'] . '%'));
            }
            $this->set('flag', 'true');
            //pr($conditions);
        }
        $this->Paginator->settings = $this->paginate;
     $category = $this->Paginator->paginate('Category',$conditions);
    $this->set('categories', $category);
//    pr($category);
//   exit();
//        $category = $this->Category->find('all', array(
//            'conditions' => $conditions));
//        $this->set('categories', $category);
        $this->set('grp_id', $grp_id);
        
    }

    /**
     * @method add
     * @uses It's use to create category.
     */
    public function add() {
        $user_id = $this->UserAuth->getUserId();
        $grp_id = $this->UserAuth->getGroupId();  
        $user_type = $this->UserAuth->getUser();
        $user_type = $user_type['UserGroup']['name'];
        $this->set('title_for_layout', 'Category add');
         $rest= $this->User->findById($user_id);
//        $user_id = $this->UserAuth->getUserId();
        $conditions = array();
        $conditions1 = array();
 if ($user_type != 'Admin') {
            if ($grp_id == '5') {
//                echo $rest_id['User']['rest_id'];
            $conditions1[] = array('OR' => array('Category.rest_id =' => $rest['User']['rest_id']));
            } else {
                $conditions1[] = array('OR' => array('Category.user_id =' => $user_id));
            }
//         $conditions[] = array('OR' => array('Category.rest_id =' => $rest_id['User']['rest_id']));
         
        }
        if ($user_type != 'Admin') {
            $conditions[] = array('OR' => array('Restaurant.user_id =' => $user_id));
        }
        if ($this->request->is('post')) {

            $category = array();
            $rest_id = $this->request->data['Category']['rest_id'];
            $userid = $this->Restaurant->findById($rest_id);

            if ($user_type != 'Admin') {
                $category['Category']['user_id'] = $user_id;
            } else {
                $category['Category']['user_id'] = $userid['Restaurant']['user_id'];
            }
            if ($grp_id == '5') {
                 $category['Category']['rest_id'] = $rest['User']['rest_id'];
                
            }
            else{
               
                  $category['Category']['rest_id'] = $this->request->data['Category']['rest_id'];
            }
            if($this->request->data['Category']['parent_id'] == null)
            {
                $cat=0;
            }
            else{
                $cat=$this->request->data['Category']['parent_id'];
            }
            $category['Category']['parent_id'] = $cat;
            $category['Category']['name'] = $this->request->data['Category']['name'];
            $category['Category']['description'] = $this->request->data['Category']['description'];
          
            
                        if ($this->Category->save($category)) {
                $category_id = $this->Category->getLastInsertId();
                $this->save_attachment($category_id, $this->request->data['Category']['icon']);


                $this->Session->setFlash(__('Your Category successfully created.'));
                $this->redirect(array('controller' => 'categories', 'action' => 'index'));
            }
        }
        //get all restaurant.
        $restaurant = $this->Restaurant->find('list', array(
            'fields' => array('Restaurant.id', 'Restaurant.name'),
            'recursive' => false,
            'conditions' => $conditions
        ));
        $this->set('restaurant', $restaurant);

        //get all category.
        $categories = $this->Category->find('list', array(
            'fields' => array('Category.id', 'Category.name'),
            'recursive' => false,
            'conditions'=>$conditions1,
        ));
//        pr($categories);
        $this->set('ctys', $categories);
        $this->set('grp_id', $grp_id);
    }

    public function save_attachment($category_id, $attachment_data) {
        $cat_array = array();
        if (!empty($attachment_data['name'])) {

            $file = $attachment_data; //put the data into a var for easy use

            $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'gif','png'); //set allowed extensions
            //only process if the extension is valid
            if (in_array($ext, $arr_ext)) {
                $filenm = $category_id . '_' . $file['name'];

                //do the actual uploading of the file. First arg is the tmp name, second arg is 
                //where we are putting it
                if (move_uploaded_file($file['tmp_name'], WWW_ROOT . 'category_images/' . $filenm))
                    {

                    //prepare the filename for database entry
                    $this->Category->saveField('icon', $filenm);
//                                $this->data['User']['image'] = $file['name'];
                }
            }
        }
    }

    /**
     * @method edit
     * @uses It's use to edit categories.
     */
    public function edit($category_id = null) {
        $this->set('title_for_layout', 'Category edit');
          $grp_id = $this->UserAuth->getGroupId();  
        $user_id = $this->UserAuth->getUserId();
  $rest= $this->User->findById($user_id);
        $user_type = $this->UserAuth->getUser();
        $user_type = $user_type['UserGroup']['name'];
$conditions=array();
        if ($user_type != 'Admin') {
            $conditions[] = array('OR' => array('Restaurant.user_id =' => $user_id));
        }
        $this->Category->id = $category_id;

        if ($this->Category->exists()) {
            if ($this->request->is('post')) {
                $category = array();
                $rest_id = $this->request->data['Category']['rest_id'];
                $userid = $this->Restaurant->findById($rest_id);

                if ($user_type != 'Admin') {
                    $category['Category']['user_id'] = $user_id;
                } else {
                    $category['Category']['user_id'] = $userid['Restaurant']['user_id'];
                }
                  if ($grp_id == '5') {
                 $category['Category']['rest_id'] = $rest['User']['rest_id'];
                
            }
            else{
               
                  $category['Category']['rest_id'] = $this->request->data['Category']['rest_id'];
            }
                if ($this->request->data['Category']['parent_id'] == NULL) {
                    $cat = 0;
                } else {
                    $cat = $this->request->data['Category']['parent_id'];
                }
                $category['Category']['parent_id'] = $cat;
                $category['Category']['name'] = $this->request->data['Category']['name'];
                $category['Category']['description'] = $this->request->data['Category']['description'];
               
                if ($this->Category->save($category)) {
                    $this->save_attachment($category_id, $this->request->data['Category']['icon']);


                    $this->Session->setFlash(__('Your category successfully Edit.'));
                    $this->redirect(array('controller' => 'categories', 'action' => 'index'));
                }
            }
            $category1 = $this->Category->findById($category_id);
            $this->set('category', $category1);
            $restuarant_id = $category1['Category']['rest_id'];
            //get all restaurant.
            $restaurant = $this->Restaurant->find('list', array(
                'fields' => array('Restaurant.id', 'Restaurant.name'),
                'recursive' => false,
                'conditions' => $conditions
            ));
            $this->set('restaurant', $restaurant);
            //get all category.
//             $conditions1[] = array('OR' => array('Category.rest_id =' => $category1['Category']['rest_id']));
            $categories = $this->Category->find('list', array(
                'fields' => array('Category.id', 'Category.name'),
                'recursive' => false,
                'conditions' => array(
                    'Category.rest_id' => $restuarant_id,
                    'NOT' => array('Category.id' =>$category_id))
            ));
            $this->set('ctys', $categories);
                   $this->set('grp_id', $grp_id);
        } else {
            $this->Session->setFlash(__('Category has not found.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * @method delete
     * @param integer $category_id
     * @return void
     */
    public function delete($category_id = null) {
        $this->set('title_for_layout', 'category delete');
        $user_id = $this->UserAuth->getUserId();
        $this->Category->id = $category_id;
        if ($this->Category->exists()) {
            if ($this->Category->delete($category_id)) {
                $this->Session->setFlash(__('Category has successfully deleted.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Category not deleted. please, try an again.'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->Session->setFlash(__('Category has not found.'));
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * @method category_builk_delete
     * @return boolean
     * @uses It's use to delete multiple categories.
     */
    public function category_builk_delete() {
        $this->layout = 'ajax';

        $category_ids = $this->request->data['category_ids'];
        $response = array();
        if (!empty($category_ids)) {
            $category_id_array = explode(',', $category_ids);
            foreach ($category_id_array as $category_id) {
                //check category is exist or not.
                $this->Category->id = $category_id;
                if ($this->Category->exists()) {
                    $this->Category->delete($category_id);
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
     * @method category_builk_delete
     * @return boolean
     * @uses It's use to delete multiple categories.
     */
    public function category_retaurant($option=null) {
        $this->layout = 'ajax';
        $this->autoRender = false;
      
        if (!empty($this->data)) {
            $restuarant_id = $this->request->data['rest_id'];
            $this->loadModel('Category');
            if($option != null){
                  $lists = $this->Category->find('all', array(
                'conditions' => array(
                    'Category.rest_id' => $restuarant_id
                    )
                ));
            }else{
            $lists = $this->Category->find('all', array(
                'conditions' => array(
                    'Category.rest_id' => $restuarant_id,
                    'NOT' => array('Category.id' =>$this->request->data['cat_id']))
                ));
            }
//            $cnt = sizeof($lists);
                $HTML = "";
            if (!empty($lists)) {
                 $HTML.="<option value='0'>None</option>";
                foreach ($lists as $list):
                    $HTML.="<option value='" . $list['Category']['id'] . "'>" . $list['Category']['name'] . "</option>";

                endforeach;
            }
            else {
//                 $HTML.="<option value='0'> No Data </option>";
               $HTML ="no data";
            }
        }
        echo $HTML;
    }
    public function validate_cat_name(){
         $this->layout = 'ajax';
          $this->autoRender = false;
//         pr($this->request->data);
        $name = $this->request->data['name'];
        $rest_id = $this->request->data['rest_id'];
        $lists = $this->Category->find('list', array(
                'conditions' => array(
                    'Category.rest_id' => $rest_id
                    ),
            'recursive' => false
                ));
//        pr($lists);
        if(in_array($name,$lists )){
            $res= 'please add another category name';            
        }
       echo $res;

        
    }
    public function get_category($id){
         $lists = $this->Category->findById($id);
         return $lists;
        
         
         
    }

}

?>