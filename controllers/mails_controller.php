<?php
  class MailsController extends NewsletterAppController {
    var $name = 'Mails';
	  var $uses = array('Newsletter.Mail', 'Newsletter.MailView', 'Newsletter.Group', 'Newsletter.GroupSubscription');
	  var $helpers = array('Time');
	  
	  var $paginate = array(
	    'Mail' => array(
		    'limit' => 40,
		    'order' => array('Mail.created' => 'desc')
		  )
	  );
	  
	 function beforeFilter() {
      parent::beforeFilter();
      #$this->Auth->allow('');
    }
    
    #Admin
	  
	  function admin_index() {
		  $this->set('mails', $this -> paginate('Mail'));
	  }
	  
	  function admin_statistics($id) {
	    $mail = $this->Mail->read(null, $id);
	    $count = $this->MailView->countViews($id);
	    $countUnique = $this->MailView->countUniqueViews($id);
	    
	    $this->set(compact('mail', 'count', 'countUnique'));
	  }
	  
	  function admin_show($id) {
	    $this->set('mail', $this->Mail->findById($id));
	    $this->layout = 'clean';
	  }
	  
	  function admin_add() {
        if(!empty($this->data)) {
            $this->data['Mail']['read_confirmation_code'] = md5(date('Y-m-d H:i:s').$this->data['Mail']['subject']);
            $this->Mail->set($this->data);
            if($this->Mail->save()) {
                $this->Session->setFlash(__('Mail successfully added', true));
                $this->redirect(array('action' => 'edit', 'id' => $this->Mail->id));
            }
        }
        $this->set('groups', $this->Group->find('list'));
    }

    function admin_edit($id = null) {
        if(!$id) {
            $this->Session->setFlash(__('Invalid mail id', true));
            $this->redirect(array('action' => 'index'));
        }
        
        if( empty($this->data) ) {
            $this->data = $this->Mail->read(null, $id);
        } else {
            $this->Mail->set($this->data);
            if( $this->Mail->save() ) {
                $this->Session->setFlash(__('Mail successfully saved', true));
            }
        }
        $this->set('groups', $this->Group->find('list'));
    }

    function admin_delete($id) {
      $this->autoRender = false;
      
      if($this->Mail->delete($id)) {
          $this->Session->setFlash(__('Mail deleted', true));
      } else {
          $this->Session->setFlash(__('Deleting failed', true));
      }
      $this->redirect(array('action' => 'index'));
    }
    
    /**
    * This action sends the next x emails for this mail.
    * @param $mail_id The Mail id. 
    **/
    function admin_send($mail_id) {
      $mail = $this->Mail->read(null, $mail_id);
      $groups = $this->extractGroups($mail);
      
      #find next subscriptions to send email
      
      #unbind for performance gain
      $this->GroupSubscription->unbindModel(array('belongsTo' => array('Group')));
      
      $last_sent = $mail['Mail']['last_sent_subscription_id']; #the last subscription_id that already received this mail
      $limit = Configure::read('Newsletter.sendX'); #the number of emails to send
      if(!$limit) {$limit = 10;} #sets default value
      
      $subscriptions = $this->GroupSubscription->find('all', array('fields' => array('Subscription.id', 'Subscription.email', 'Subscription.name'), 'conditions' => array('newsletter_group_id' => $groups, 'Subscription.id >' => $last_sent), 'order' => 'Subscription.created', 'limit' => $limit));
      
      if(!empty($subscriptions)) {      
        $this->set('content', $mail['Mail']['content']);
        $this->sendEmail($mail['Mail']['subject'], 'mail', $this->extractEmailAndName($subscriptions), $mail['Mail']['from_email'], $mail['Mail']['from']);
        
        #updated last_sent_subscription_id
        $last_element = end($subscriptions);
        $mail['Mail']['last_sent_subscription_id'] = $last_element['Subscription']['id'];
        $this->Mail->create($mail);
        $this->Mail->save();
      }
    }
    
    function extractGroups($data) {
      $groups = array();
      
      if(!empty($data) && array_key_exists('Group', $data)) { 
        foreach ($data['Group'] as $key => $group) {
          array_push($groups, $group['id']);
        }
      }
      return $groups;
    }
    
    function extractEmailAndName($data) {
      $list = array();
      
      if(!empty($data)) { 
        foreach ($data as $key => $subscription) {
          $list[$subscription['Subscription']['email']] = $subscription['Subscription']['name'];
        }
      }
      return $list;
    }
    
  }
?>
