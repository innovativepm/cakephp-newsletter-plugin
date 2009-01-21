<?php
App::import('Controller', 'Newsletter.Mails');

/**
* Controller mock class.
**/ 
class TestMailsController extends MailsController {
    var $name = 'Mails';
    var $autoRender = false;
 
    function redirect($url, $status = null, $exit = true) {
        $this->redirectUrl = $url;
    }
 
    function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
    
    function paginate($object = null, $scope = array(), $whitelist = array()) {
      return $this->Mail->find('all', array('conditions' => $scope));
    }
 
    function _stop($status = 0) {
        $this->stopped = $status;
    }
}
 
class MailsControllerTestCase extends CakeTestCase {

    var $fixtures = array('plugin.newsletter.mail');
 
    function startTest() {
      $this->Mails = new TestMailsController();
      $this->Mails->constructClasses();
      $this->Mails->Component->initialize($this->Mails);
    }
    
    function testAdminShow() {
      $this->Mails->beforeFilter();
      $this->Mails->Component->startup($this->Mails);
      $this->Mails->admin_show(1);
      
      $this->assertNotNull($this->Mails->viewVars['mail']);
    }
    
    function testAdminIndex() {
      $this->Mails->beforeFilter();
      $this->Mails->Component->startup($this->Mails);
      $this->Mails->admin_index();
      
      $this->assertNotNull($this->Mails->viewVars['mails']);
    }
    
    function testAdminAdd() {
      $this->Mails->data = array(
        'Mail' => array(
            'from' => 'Fake From',
            'from_email' => 'fake@email.com',
            'subject' => 'Fake Subject',
            'content' => 'Fake Content'
        ),
      );
      $this->Mails->beforeFilter();
      $this->Mails->Component->startup($this->Mails);
      $this->Mails->admin_add();
    
      //assert the record was changed
      $result = $this->Mails->Mail->read(null, $this->Mails->Mail->id);
      $this->assertEqual($result['Mail']['from'], 'Fake From');
      $this->assertEqual($result['Mail']['from_email'], 'fake@email.com');
      $this->assertEqual($result['Mail']['subject'], 'Fake Subject');
      $this->assertEqual($result['Mail']['content'], 'Fake Content');
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Mails->Session->check('Message.flash.message'));
      $this->assertEqual($this->Mails->redirectUrl, array('action' => 'edit', 'id' => $this->Mails->Mail->id));
    }
    
    function testAdminEdit() {
      $this->Mails->data = array(
        'Mail' => array(
            'id' => 1,
            'from' => 'Fake From',
            'from_email' => 'fake@email.com',
            'subject' => 'Fake Subject',
            'content' => 'Fake Content'
        ),
      );

      $this->Mails->beforeFilter();
      $this->Mails->Component->startup($this->Mails);
      $this->Mails->admin_edit();
    
      //assert the record was changed
      $result = $this->Mails->Mail->read(null, 1);
      $this->assertEqual($result['Mail']['from'], 'Fake From');
      $this->assertEqual($result['Mail']['from_email'], 'fake@email.com');
      $this->assertEqual($result['Mail']['subject'], 'Fake Subject');
      $this->assertEqual($result['Mail']['content'], 'Fake Content');
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Mails->Session->check('Message.flash.message'));
      $this->assertEqual($this->Mails->redirectUrl, array('action' => 'index'));
      
      //test for edit without data
      $this->Mails->beforeFilter();
      $this->Mails->Component->startup($this->Mails);
      $this->Mails->admin_edit(1);
      
      $this->assertNotNull($this->Mails->data);
    }
    
    function testAdminDelete() {
      $this->Mails->beforeFilter();
      $this->Mails->Component->startup($this->Mails);
      $this->Mails->admin_delete(1);
    
      //assert the record was changed
      $result = $this->Mails->Mail->read(null, 1);
      $this->assertFalse($result);
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Mails->Session->check('Message.flash.message'));
      $this->assertEqual($this->Mails->redirectUrl, array('action' => 'index'));
    }
 
    function endTest() {
      $this->Mails->Session->destroy();
      unset($this->Mails);
      ClassRegistry::flush();
    }
}
?>
