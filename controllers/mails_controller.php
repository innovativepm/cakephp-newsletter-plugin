<?php
  class MailsController extends NewsletterAppController {
    var $name = 'Mails';
	  var $uses = array('Newsletter.Mail');
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
	  
	  function admin_add() {
        if(!empty($this->data)) {
            $this->Mail->set($this->data);
            if($this->Mail->save()) {
                $this->Session->setFlash(__('Mail successfully added', true));
                $this->redirect(array('action' => 'edit', 'id' => $this->Mail->id));
            }
        }
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
    
  }
?>
