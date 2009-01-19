<?php
App::import('Controller', 'Newsletter.Subscriptions');

/**
* Controller mock class.
**/ 
class TestSubscriptionsController extends SubscriptionsController {
    var $name = 'Subscriptions';
    var $autoRender = false;
 
    function redirect($url, $status = null, $exit = true) {
        $this->redirectUrl = $url;
    }
 
    function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
    
    function paginate($object = null, $scope = array(), $whitelist = array()) {
      return $this->Subscription->find('all', array('conditions' => $scope));
    }
 
    function _stop($status = 0) {
        $this->stopped = $status;
    }
}
 
class SubscriptionsControllerTestCase extends CakeTestCase {

    var $fixtures = array('plugin.newsletter.subscription');
 
    function startTest() {
      $this->Subscriptions = new TestSubscriptionsController();
      $this->Subscriptions->constructClasses();
      $this->Subscriptions->Component->initialize($this->Subscriptions);
    }
    
    function testAdminIndex() {
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->admin_index();
      
      $this->assertNotNull($this->Subscriptions->viewVars['subscriptions']);
      
      //with filter
      $this->Subscriptions->data = array('Filter' => array('value' => 'someone@subscribed.com')); 
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->admin_index();
      
      $this->assertNotNull($this->Subscriptions->viewVars['subscriptions']);
      $this->assertEqual('1', $this->Subscriptions->viewVars['subscriptions'][0]['Subscription']['id']);
    }
    
    function testAdminAdd() {
      $this->Subscriptions->data = array(
        'Subscription' => array(
            'name' => 'Fake Subscription',
            'email' => 'fake@subscription.com',
        ),
      );
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->admin_add();
    
      //assert the record was changed
      $result = $this->Subscriptions->Subscription->read(null, $this->Subscriptions->Subscription->id);
      $this->assertEqual($result['Subscription']['name'], 'Fake Subscription');
      $this->assertEqual($result['Subscription']['email'], 'fake@subscription.com');
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
      $this->assertEqual($this->Subscriptions->redirectUrl, array('action' => 'edit', 'id' => $this->Subscriptions->Subscription->id));
    }
    
    function testAdminEdit() {
      $this->Subscriptions->data = array(
        'Subscription' => array(
            'id' => 1,
            'name' => 'Fake Subscription',
            'email' => 'fake@subscription.com',
        ),
      );
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->admin_edit();
    
      //assert the record was changed
      $result = $this->Subscriptions->Subscription->read(null, 1);
      $this->assertEqual($result['Subscription']['name'], 'Fake Subscription');
      $this->assertEqual($result['Subscription']['email'], 'fake@subscription.com');
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
      $this->assertEqual($this->Subscriptions->redirectUrl, array('action' => 'index'));
      
      //test for edit without data
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->admin_edit(1);
      
      $this->assertNotNull($this->Subscriptions->data);
    }
    
    function testAdminDelete() {
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->admin_delete(1);
    
      //assert the record was changed
      $result = $this->Subscriptions->Subscription->read(null, 1);
      $this->assertFalse($result);
    
      //assert that some sort of session flash was set.
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
      $this->assertEqual($this->Subscriptions->redirectUrl, array('action' => 'index'));
    }
    
    function testInvertOptOut() {
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->admin_invert_opt_out(1);
      
      //assert the record was changed
      $result = $this->Subscriptions->Subscription->read(null, 1); //not into opt_out
      $this->assertNotNull($result['Subscription']['opt_out_date']);
      
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->admin_invert_opt_out(3);
      
      //assert the record was changed
      $result = $this->Subscriptions->Subscription->read(null, 3); //already in opt_out
      $this->assertNull($result['Subscription']['opt_out_date']);
    }
    
    function testUnsubscribe() {
      #test for subscribed user
      $this->Subscriptions->data = array('Subscription' => array('email' => 'someone@subscribed.com'));
    
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->unsubscribe();
      
      $result = $this->Subscriptions->Subscription->read(null, 1);
      $this->assertNotNull($result['Subscription']['opt_out_date']);
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
      
      #test for not yet subscribed user
      $this->Subscriptions->data = array('Subscription' => array('email' => 'notfound'));
    
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->unsubscribe();
      
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
      
      #test for subscribed user already in opt_out
      $this->Subscriptions->data = array('Subscription' => array('email' => 'opt@out.com'));
    
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->unsubscribe();
      
      $result = $this->Subscriptions->Subscription->read(null, 1);
      $this->assertNotNull($result['Subscription']['opt_out_date']);
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
    }
    
    function testSubscribe() {
      #test for new subscriptions
      $this->Subscriptions->data = array('Subscription' => array('name' => 'New Subscription', 'email' => 'new@subscription.com'));
      
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->subscribe();
      
      $result = $this->Subscriptions->Subscription->read(null, $this->Subscriptions->Subscription->id);
      $this->assertNotNull($result);
      $this->assertEqual($result['Subscription']['name'], 'New Subscription');
      $this->assertEqual($result['Subscription']['email'], 'new@subscription.com');
      $this->assertNotNull($result['Subscription']['confirmation_code']);
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
      
      #test for existing subscription currently in opt_out
      $this->Subscriptions->data = array('Subscription' => array('name' => 'New Name', 'email' => 'opt@out.com'));
      
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->subscribe();
      
      $result = $this->Subscriptions->Subscription->read(null, 3);
      $this->assertNotNull($result);
      $this->assertEqual($result['Subscription']['name'], 'New Name');
      $this->assertEqual($result['Subscription']['email'], 'opt@out.com');
      $this->assertNotNull($result['Subscription']['confirmation_code']);
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
      
      #test for existing subscription currently waiting confirmation
      $this->Subscriptions->data = array('Subscription' => array('name' => 'New Name', 'email' => 'someone@waiting.com'));
      
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->subscribe();
      
      $result = $this->Subscriptions->Subscription->read(null, 2);
      $this->assertNotNull($result);
      $this->assertEqual($result['Subscription']['name'], 'New Name');
      $this->assertEqual($result['Subscription']['email'], 'someone@waiting.com');
      $this->assertNotNull($result['Subscription']['confirmation_code']);
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
      
      #test for existing subscription currently in opt_in
      $this->Subscriptions->data = array('Subscription' => array('name' => 'Any Name', 'email' => 'someone@subscribed.com'));
      
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->subscribe();
      
      $result = $this->Subscriptions->Subscription->read(null, 1);
      $this->assertNotNull($result);
      $this->assertEqual($result['Subscription']['name'], 'Subscribed');
      $this->assertEqual($result['Subscription']['email'], 'someone@subscribed.com');
      $this->assertNull($result['Subscription']['confirmation_code']);
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
    }
    
    function testConfirmSubscription() {
      #test for existing subscription currently waiting confirmation
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->confirm_subscription('some_code');
      
      $result = $this->Subscriptions->Subscription->read(null, 2);
      $this->assertNotNull($result);
      $this->assertNull($result['Subscription']['confirmation_code']);
      $this->assertNull($result['Subscription']['opt_out_date']);
      $this->assertNotNull($this->Subscriptions->viewVars['subscribed']);
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
      
      #test for invalid confirmation code
      $this->Subscriptions->beforeFilter();
      $this->Subscriptions->Component->startup($this->Subscriptions);
      $this->Subscriptions->confirm_subscription('invalid_code');
      
      $this->assertTrue($this->Subscriptions->Session->check('Message.flash.message'));
    }
 
    function endTest() {
      $this->Subscriptions->Session->destroy();
      unset($this->Subscriptions);
      ClassRegistry::flush();
    }
}
?>
