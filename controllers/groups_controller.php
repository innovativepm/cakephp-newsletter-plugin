<?php
  class GroupsController extends NewsletterAppController {
    var $name = 'Groups';
	  var $uses = array('Newsletter.Group', 'Newsletter.Subscription');
	  var $helpers = array('Time');
	  
	  var $paginate = array(
	    'Group' => array(
		    'limit' => 40,
		    'order' => array('Group.name' => 'asc')
		  ),
		  'Subscription' => array(
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
	    $this->Subscription->bindModel(array('hasOne' => array('NewsletterSubscriptionsGroups')));
	    #$subcriptions = $this->Subscription->find('all', array('fields' => array('Subscription.*'), 'conditions' => array('NewsletterSubscriptionsGroups.newsletter_group_id' => $id)));	    
	    
	    $subcriptions = $this->paginate('Subscription', array('NewsletterSubscriptionsGroups.newsletter_group_id' => $id));
	    
	    $this->set('subscriptions', $subcriptions);
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
