<?php
  class SubscriptionsController extends NewsletterAppController {
    var $name = 'Subscriptions';
	  var $uses = array('Newsletter.Subscription');
	  var $helpers = array('Time');
	  
	  var $paginate = array(
	    'Subscription' => array(
		    'limit' => 40,
		    'order' => array('Subscription.email' => 'asc')
		  )
	  );
	  
	 function beforeFilter() {
      parent::beforeFilter();
      #$this->Auth->allow();
    }
	  
	  function admin_index() {
	    $conditions = null;
	  
	    if($this->isNotEmpty('Filter.value')) {
	      $filter = $this->data['Filter']['value'];
	      $conditions = array('OR' => array(
					'Subscription.name LIKE' => '%'.$filter.'%',
					'Subscription.email LIKE' => '%'.$filter.'%',
					)
				);
	    }
		  $this->set('subscriptions', $this -> paginate('Subscription', $conditions));
	  }
	  
	  public function admin_add() {
        if(!empty($this->data)) {
            $this->Subscription->set($this->data);
            if($this->Subscription->save()) {
                $this->Session->setFlash(__('Subscription successfully added', true));
                $this->redirect(array('action' => 'edit', 'id' => $this->Subscription->id));
            }
        }
    }

    public function admin_edit($id = null) {
        if(!$id) {
            $this->Session->setFlash(__('Invalid subscription id', true));
            $this->redirect(array('action' => 'index'));
        }
        
        if( empty($this->data) ) {
            $this->data = $this->Subscription->read(null, $id);
        } else {
            $this->Subscription->set($this->data);
            if( $this->Subscription->save() ) {
                $this->Session->setFlash(__('Subscription successfully saved', true));
            }
        }
    }

    public function admin_delete($id) {
      $this->autoRender = false;
      
      if($this->Subscription->delete($id)) {
          $this->Session->setFlash(__('Subscription deleted', true));
      } else {
          $this->Session->setFlash(__('Deleting failed', true));
      }
      $this->redirect(array('action' => 'index'));
    }
    
    public function admin_invert_opt_out($id) {
      $this->Subscription->id = $id;
      $subscribed = $this->Subscription->read();
      
      if($subscribed['Subscription']['opt_out_date']) {
        $this->Subscription->saveField('opt_out_date', null);
      } else {
        $this->Subscription->saveField('opt_out_date', date('Y-m-d H:i:s'));
      }
      $this->Session->setFlash(__('Subscription updated', true));
      $this->redirect(array('action' => 'index'));
    }
  }
?>
