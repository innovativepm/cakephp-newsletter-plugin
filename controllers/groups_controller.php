<?php
/**
* Copyright (c) 2009, Fabio Kreusch
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
* @copyright            Copyright (c) 2009, Fabio Kreusch
* @link                 fabio.kreusch.com.br
* @license              http://www.opensource.org/licenses/mit-license.php The MIT License
*/
class GroupsController extends NewsletterAppController {
  var $name = 'Groups';
  var $uses = array('Newsletter.Group', 'Newsletter.GroupSubscription');
  var $helpers = array('Time');
  
  var $paginate = array(
    'Group' => array(
	    'limit' => 40,
	    'order' => array('Group.name' => 'asc')
	  ),
	  'GroupSubscription' => array(
	    'limit' => 40,
	    'order' => array('Subscription.email' => 'asc')
	  )
  );
  
 function beforeFilter() {
    parent::beforeFilter();
    #$this->Auth->allow('');
  }
  
  #Admin
  
  function admin_index() {
	  $this->set('groups', $this -> paginate('Group'));
  }
  
  function admin_list_subscriptions($id) {
    $subcriptions = $this->paginate('GroupSubscription', array('GroupSubscription.newsletter_group_id' => $id, 'Subscription.id <>' => null));
    $this->set('subscriptions', $subcriptions);
    $this->set('group', $this->Group->read(null, $id)); 
  }
  
  function admin_add() {
      if(!empty($this->data)) {
          $this->Group->set($this->data);
          if($this->Group->save()) {
              $this->Session->setFlash(__('Group successfully added', true));
              $this->redirect(array('action' => 'edit', 'id' => $this->Group->id));
          }
      }
  }

  function admin_edit($id = null) {
      if(!$id) {
          $this->Session->setFlash(__('Invalid group id', true));
          $this->redirect(array('action' => 'index'));
      }
      
      if( empty($this->data) ) {
          $this->data = $this->Group->read(null, $id);
      } else {
          $this->Group->set($this->data);
          if( $this->Group->save() ) {
              $this->Session->setFlash(__('Group successfully saved', true));
          }
      }
  }

  function admin_delete($id) {
    $this->autoRender = false;
    
    if($this->Group->delete($id)) {
        $this->Session->setFlash(__('Group deleted', true));
    } else {
        $this->Session->setFlash(__('Deleting failed', true));
    }
    $this->redirect(array('action' => 'index'));
  }
  
}
?>
