<?php
App::import('Controller', 'Newsletter.Subscriptions');

/**
* Controller mock class.
**/ 
class TestNewsletterAppController extends SubscriptionsController {
    var $name = 'Subscriptions';
    var $autoRender = false;
 
    function redirect($url, $status = null, $exit = true) {
        $this->redirectUrl = $url;
    }
 
    function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
    
    function paginate($object = null, $scope = array(), $whitelist = array()) {
      return $this->Subscription->find('all');
    }
 
    function _stop($status = 0) {
        $this->stopped = $status;
    }
    
}
 
class NewsletterAppControllerTestCase extends CakeTestCase {
 
    var $fixtures = array('plugin.newsletter.groups_subscriptions', 'plugin.newsletter.group', 'plugin.newsletter.subscription');
 
    function startTest() {
      $this->Subscriptions = new TestNewsletterAppController();
      $this->Subscriptions->constructClasses();
      $this->Subscriptions->Component->initialize($this->Subscriptions);
    }
    
    function testIsNotEmpty() {
      $testArray = array('Form' => array('field' => 1));
      
      $this->assertTrue($this->Subscriptions->isNotEmpty('Form', $testArray));
      $this->assertTrue($this->Subscriptions->isNotEmpty('Form.field', $testArray));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Other', $testArray));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Other.field', $testArray));
      
      $testArray = array('Form' => array('field' => null));
      
      $this->assertTrue($this->Subscriptions->isNotEmpty('Form', $testArray));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Form.field', $testArray));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Other', $testArray));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Other.field', $testArray));
      
      $testArray = array('Test' => array('field' => 1));
      $this->Subscriptions->data = $testArray;
      
      $this->assertTrue($this->Subscriptions->isNotEmpty('Test'));
      $this->assertTrue($this->Subscriptions->isNotEmpty('Test.field'));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Other'));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Other.field'));
      
      $testArray = array('Test' => array('field' => null));
      $this->Subscriptions->data = $testArray;
      
      $this->assertTrue($this->Subscriptions->isNotEmpty('Test'));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Test.field'));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Other'));
      $this->assertFalse($this->Subscriptions->isNotEmpty('Other.field'));
    }
 
    function endTest() {
      $this->Subscriptions->Session->destroy();
      unset($this->Subscriptions);
      ClassRegistry::flush();
    }
}
?>
