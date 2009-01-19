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
      $this->Auth->allow('opt_in', 'opt_out');
    }
    
    #Public
    
    function unsubscribe() {
      if($this->isNotEmpty('Subscription.email')) {
        $subscribed = $this->Subscription->findByEmail($this->data['Subscription']['email']);
        if($subscribed) {
          $this->Subscription->id = $subscribed['Subscription']['id'];
          $this->Subscription->saveField('opt_out_date', date('Y-m-d H:i:s'));
          
          #TODO send email
          $this->Session->setFlash(__('The requested email was withdrawn from the mail list', true));
        } else {
          $this->Session->setFlash(__('Email not in subscription list', true));
        }
      }
    }
    
    function subscribe() {
      if(!empty($this->data) && $this->isNotEmpty('Subscription.email')) {
        $subscribed = $this->Subscription->findByEmail($this->data['Subscription']['email']);
        
        #if the email isn't yet registered or if it already exists but is into opt_out or it's waiting for confirmation, 
        #save and set the user confirmation code and send email, otherwise tell the user he already is opt_in
        if(empty($subscribed) || 
          !empty($subscribed['Subscription']['opt_out_date']) ||
          !empty($subscribed['Subscription']['confirmation_code'])
        ) {
          $confirmation_code = md5(date('Y-m-d H:i:s').$this->data['Subscription']['name'].$this->data['Subscription']['email']);
          
          if(!empty($subscribed)) {
            $this->data['Subscription']['id'] = $subscribed['Subscription']['id'];
          }
          
          $this->data['Subscription']['confirmation_code'] = $confirmation_code;
          $this->Subscription->set($this->data);
          $this->Subscription->save();
          
          $this->Session->setFlash(__('A confirmation message was sent to your email', true));
          #TODO send email
        } else {
          $this->Session->setFlash(__('The requested email is already into the list', true));
        }
      }
    }
    
    function confirm_subscription($id) {
      $subscribed = $this->Subscription->findByConfirmationCode($id);
      
      if(!empty($subscribed)) {
        $subscribed['Subscription']['opt_out_date'] = null;
        $subscribed['Subscription']['confirmation_code'] = null;
        $this->Subscription->set($subscribed);
        $this->Subscription->save();
        
        $this->Session->setFlash(__('Subscription confirmed', true));
      } else {
        $this->Session->setFlash(__('Invalid confirmation code', true));
      }
    } 
    
    #Admin
	  
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
