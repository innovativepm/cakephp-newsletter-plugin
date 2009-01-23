<?php
  class SubscriptionsController extends NewsletterAppController {
    var $name = 'Subscriptions';
	  var $uses = array('Newsletter.Group', 'Newsletter.Subscription');
	  var $helpers = array('Time');
	  
	  var $paginate = array(
	    'Subscription' => array(
		    'limit' => 40,
		    'order' => array('Subscription.email' => 'asc')
		  )
	  );
	  
	 function beforeFilter() {
      parent::beforeFilter();
      $this->Auth->allow('unsubscribe', 'subscribe', 'confirm_subscription');
    }
    
    #Public
    
    function unsubscribe() {
      if($this->isNotEmpty('Subscription.email')) {
        $subscribed = $this->Subscription->find('first', array('conditions' => array('email' => $this->data['Subscription']['email'], 'opt_out_date' => null)));
        if($subscribed) {
          $this->Subscription->id = $subscribed['Subscription']['id'];
          $this->Subscription->saveField('opt_out_date', date('Y-m-d H:i:s'));
          
          #send email
          $subject = Configure::read('Newsletter.unsubscribe_subject');
          if(!$subject) { $subject = 'Unsubscribe Confirmation'; }
           
          $subscription = $this->Subscription->read(); 
          $this->sendEmail($subject, 'unsubscribe', $subscription['Subscription']['email']);  
          
          $message = Configure::read('Newsletter.unsubscribe_site_message');
          if(!$message) {$message = __('The requested email was withdrawn from the mail list', true);}
          $this->Session->setFlash($message);
        } else {
          $message = Configure::read('Newsletter.unsubscribe_not_found_site_message');
          if(!$message) {$message = __('Email not in subscription list', true);}
          $this->Session->setFlash($message);
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
          
          #adds subscription to default site_group
          $site_group = Configure::read('Newsletter.siteGroup');
          if(!$site_group) {$site_group = '1';}
          $this->Subscription->habtmAdd('Group', $this->Subscription->id, $site_group);
          
          #send email
          $subject = Configure::read('Newsletter.subscribe_subject');
          if(!$subject) { $subject = 'Subscription Confirmation'; }
           
          $subscription = $this->Subscription->read(null, $this->Subscription->id); 
          $this->set('confirmation_code', $subscription['Subscription']['confirmation_code']);
          $this->sendEmail($subject, 'subscribe', $subscription['Subscription']['email']);  
          
          $message = Configure::read('Newsletter.subscribe_site_message');
          if(!$message) {$message = __('A confirmation message was sent to your email', true);}
          $this->Session->setFlash($message);
        } else {
          $message = Configure::read('Newsletter.subscribe_already_in_list');
          if(!$message) {$message = __('The requested email is already into the list', true);}
          $this->Session->setFlash($message);
        }
      }
    }
    
    function confirm_subscription($id) {
      $subscribed = $this->Subscription->findByConfirmationCode($id);
      
      if(!empty($id) && !empty($subscribed)) {
        $subscribed['Subscription']['opt_out_date'] = null;
        $subscribed['Subscription']['confirmation_code'] = null;
        $this->Subscription->set($subscribed);
        $this->Subscription->save();
        
        $this->set('subscribed', $subscribed);
        
        $message = Configure::read('Newsletter.subscribe_confirmation');
        if(!$message) {$message = __('Subscription confirmed', true);}
        $this->Session->setFlash($message);
      } else {
        $message = Configure::read('Newsletter.subscribe_confirmation_invalid');
        if(!$message) {$message = __('Invalid confirmation code', true);}
        $this->Session->setFlash($message);
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
	  
	  function admin_add() {
        if(!empty($this->data)) {
            $this->Subscription->set($this->data);
            if($this->Subscription->save()) {
                $this->Session->setFlash(__('Subscription successfully added', true));
                $this->redirect(array('action' => 'edit', 'id' => $this->Subscription->id));
            }
        }
        $this->set('groups', $this->Group->find('list'));
    }

    function admin_edit($id = null) {
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
        
        $this->set('groups', $this->Group->find('list'));
    }

    function admin_delete($id) {
      $this->autoRender = false;
      
      if($this->Subscription->delete($id)) {
          $this->Session->setFlash(__('Subscription deleted', true));
      } else {
          $this->Session->setFlash(__('Deleting failed', true));
      }
      $this->redirect(array('action' => 'index'));
    }
    
    # TODO tratement for if the admin is in a paginate specific page
    function admin_invert_opt_out($id) {
      $this->Subscription->id = $id;
      $subscribed = $this->Subscription->read();
      
      if($subscribed['Subscription']['opt_out_date']) {
        $this->Subscription->saveField('opt_out_date', null);
      } else {
        $this->Subscription->saveField('opt_out_date', date('Y-m-d H:i:s'));
      }
      
      $subscribed = $this->Subscription->read();
      $this->layout = 'clean';
      $this->set('subscription', $subscribed);
    }
    
    /*function admin_import_csv() {
      if (!empty($this->data) && is_uploaded_file($this->data['Subscription']['csv']['tmp_name'])) {
		    set_time_limit(0);
		    
		    $lines = $this->readUploadedCSV($this->data['Subscription']['csv']['tmp_name']);
			  $errors = array();
			  $data = array();

			  foreach($lines as $number => $line) {
				  $error = $this->validateCSVLine($line, ($number+1));
				  if(count($error)>0) {
					  $errors = array_merge($errors, $error);
				  } else {
				    $line_data = array('Subscription' => array('email' => $line[0], 'name' => $line[1]));
				    array_push($data, $line_data);
				    #$this->Subscription->create(array('id' => null, 'Subscription' => array('email' => $line[0], 'name' => $line[1])));
				    #$this->Subscription->save();
				  }
			  }
			  
			  $this->Subscription->saveSubscriptionsBatchMode($data);
			  #debug($data);

			  $this->set('errors', $errors);
			  $this->Session->setFlash(__('Data imported', true));
	      $this->redirect(array('action' => 'index'));
		  } else {
		    $this->Session->setFlash(__('No data to import', true));
		    $this->redirect(array('action' => 'index'));
		  }
    }*/
    
    /**
	  * Reads a CSV file and returns a list with each line.
	  * @param $tmp_name The CSV path.
	  * @return An array with each line.
	  * @access private
	  **/
	  /*function readUploadedCSV($tmp_name) {
		  $lines = array();

		  ini_set('auto_detect_line_endings',1);
		  $handle = fopen($tmp_name, "r");
		  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			  array_push($lines,$data);			 
		  }
		  return $lines;
	  }*/
	  
	  /**
	  * Validates a csv line, verifying if it has a valid email.
	  * @param $list A csv array as returned by _read_uploaded_csv().
	  * @return Array with errors, if any. False otherwise.
	  * @access true
	  **/
	  /*function validateCSVLine($line, $line_number) {
		  $errors = array();

		  if(!is_array($line)) {
			  array_push($errors,'Invalid line');			 
		  }

		  if($line[0] == null || $line[0] == '') {
			  array_push($errors, "Error in line $line_number: blank email");
		  }

		  return $errors;
	  }*/
  }
?>
