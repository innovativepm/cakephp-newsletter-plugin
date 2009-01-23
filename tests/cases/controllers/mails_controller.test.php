<?php
App::import('Controller', 'Newsletter.Mails');

/**
* Controller mock class.
**/ 
class TestMailsController extends MailsController {
    var $name = 'Mails';
    var $autoRender = false;
    var $emails = array();
 
    function redirect($url, $status = null, $exit = true) {
        $this->redirectUrl = $url;
    }
 
    function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
    
    function paginate($object = null, $scope = array(), $whitelist = array()) {
      return $this->Mail->find('all', array('conditions' => $scope));
    }
    
    #mock: for each email call, add an entry to the $this->emails list.
    function sendEmail($subject, $view, $to=null, $from = null, $fromName = null) {
      array_push($this->emails, array(
        'subject' => $subject,
        'view' => $view,
        'to' => $to,
        'from_email' => $from,
        'from' => $fromName,
      ));
    }
 
    function _stop($status = 0) {
        $this->stopped = $status;
    }
}
 
class MailsControllerTestCase extends CakeTestCase {

    var $fixtures = array('plugin.newsletter.mail', 'plugin.newsletter.mail_view', 'plugin.newsletter.groups_mails', 'plugin.newsletter.groups_subscriptions', 'plugin.newsletter.group', 'plugin.newsletter.subscription');
 
    function startTest() {
      $this->Mails = new TestMailsController();
      $this->Mails->constructClasses();
      $this->Mails->Component->initialize($this->Mails);
    }
    
    function testRead() {
      Configure::write('Newsletter.emptyImagePath', 'test');
      $this->Mails->read('12345');
      $this->assertEqual('test', $this->Mails->redirectUrl);
      
      $count = $this->Mails->MailView->find('count', array('conditions' => array('newsletter_mail_id' => 1)));
      $this->assertEqual(5, $count);
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
      $this->assertNotNull($result['Mail']['read_confirmation_code']);
      $this->assertEqual($result['Mail']['from'], 'Fake From');
      $this->assertEqual($result['Mail']['from_email'], 'fake@email.com');
      $this->assertEqual($result['Mail']['subject'], 'Fake Subject');
      $this->assertEqual($result['Mail']['content'], 'Fake Content');
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Mails->Session->check('Message.flash.message'));
      $this->assertEqual($this->Mails->redirectUrl, array('action' => 'edit', 'id' => $this->Mails->Mail->id));
      
      $this->assertNotNull($this->Mails->viewVars['groups']);
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
      
      $this->assertNotNull($this->Mails->viewVars['groups']);
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
    
    function testAdminStatistics() {
      $this->Mails->beforeFilter();
      $this->Mails->Component->startup($this->Mails);
      $this->Mails->admin_statistics(1);
    
      $this->assertNotNull($this->Mails->viewVars['mail']);
      $this->assertNotNull($this->Mails->viewVars['count']);
      $this->assertNotNull($this->Mails->viewVars['countUnique']);
      $this->assertNotNull($this->Mails->viewVars['rest']);
    }
    
    function testAdminReset() {
      $this->Mails->admin_reset(1);
      
      $mail = $this->Mails->Mail->read(null, 1);
      $this->assertEqual(0, $mail['Mail']['sent']);
      $this->assertEqual(0, $mail['Mail']['last_sent_subscription_id']);
      
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Mails->Session->check('Message.flash.message'));
      $this->assertEqual($this->Mails->redirectUrl, array('action' => 'index'));
    }
    
    function testAdminSend() {
      Configure::write('Newsletter.sendX', 2);
      Configure::write('Newsletter.sendInterval', 10);
      $this->Mails->admin_send(1);
    
      #view vars
      $this->assertNotNull($this->Mails->viewVars['mail']);
      $this->assertEqual(1, $this->Mails->viewVars['sent']);
      $this->assertEqual(3, $this->Mails->viewVars['rest']);
      $this->assertEqual(2, $this->Mails->viewVars['limit']);
      $this->assertEqual(10, $this->Mails->viewVars['interval']);
    }
    
    function testAdminSendMail() {
      
      #Test for mail 1
      Configure::write('Newsletter.sendX', 2);
      $this->Mails->admin_send_mail(1);
      
      $emails = $this->Mails->emails;
      $this->assertEqual(1, count($emails));
      
      $emails = $emails[0];
      
      #expects two emails to be sent to the following subscribeds      
      $expected = array('someone@waiting.com' => 'Waiting Confirmation', 'group2@subscription.com' => 'Subscription in Group 2');
      $this->assertEqual($expected, $emails['to']);
      $this->assertEqual('My Mail', $emails['subject']);
      $this->assertEqual('mail', $emails['view']);
      $this->assertEqual('Welcome!', $this->Mails->viewVars['content']);
      $this->assertEqual('12345', $this->Mails->viewVars['readConfirmationCode']);
      
      #assert it has updated the 'last_sent_subscription_id' and 'sent' with the last subscription (3)
      $mail = $this->Mails->Mail->read(null, 1);
      $this->assertEqual(4, $mail['Mail']['last_sent_subscription_id']);
      $this->assertEqual(3, $mail['Mail']['sent']);
      
      #view vars
      $this->assertEqual(3, $this->Mails->viewVars['sent']);
      $this->assertEqual(1, $this->Mails->viewVars['rest']);
      $this->assertEqual(2, $this->Mails->viewVars['limit']);
    }
    
    function testAdminSendMail2() {
      #Test for mail 2
      Configure::write('Newsletter.sendX', 2);
      $this->Mails->admin_send_mail(2);
      
      $emails = $this->Mails->emails;
      $this->assertEqual(1, count($emails));
      
      $emails = $emails[0];
      
      #expects one email to be sent to the following subscribed      
      $expected = array('group2@subscription.com' => 'Subscription in Group 2');
      $this->assertEqual($expected, $emails['to']);
      $this->assertEqual('Another Mail', $emails['subject']);
      $this->assertEqual('mail', $emails['view']);
      $this->assertEqual('Welcome!', $this->Mails->viewVars['content']);
      $this->assertEqual('123456', $this->Mails->viewVars['readConfirmationCode']);
      
      #assert it has updated the 'last_sent_subscription_id' and 'sent' with the last subscription (4)
      $mail = $this->Mails->Mail->read(null, 2);
      $this->assertEqual(4, $mail['Mail']['last_sent_subscription_id']);
      $this->assertEqual(1, $mail['Mail']['sent']);
      
      #view vars
      $this->assertEqual(1, $this->Mails->viewVars['sent']);
      $this->assertEqual(0, $this->Mails->viewVars['rest']);
      $this->assertEqual(2, $this->Mails->viewVars['limit']);
    }
    
    function testExtractEmailAndName() {
      $data = array();
      array_push($data, array(
        'Subscription' => array('email' => 'email1', 'name' => 'name1')
      ));
      array_push($data, array(
        'Subscription' => array('email' => 'email2', 'name' => 'name2')
      ));
      
      $result = $this->Mails->extractEmailAndName($data);
      $this->assertEqual('name1', $result['email1']);
      $this->assertEqual('name2', $result['email2']);
      
      #test empty
      $data = array();
      
      $result = $this->Mails->extractEmailAndName($data);
      $expected = array();
      $this->assertEqual($expected, $result);
    }

    function endTest() {
      $this->Mails->Session->destroy();
      unset($this->Mails);
      ClassRegistry::flush();
    }
}
?>
