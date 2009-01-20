<?php 
  App::import('Model', 'Newsletter.Subscription');
  App::import('Model', 'Newsletter.Group');

  class SubscriptionCase extends CakeTestCase {

      var $fixtures = array('plugin.newsletter.subscriptions_groups', 'plugin.newsletter.group', 'plugin.newsletter.subscription');
      var $SubscriptionTest;
      
      function start() {
		    parent::start();
		    $this->SubscriptionTest = ClassRegistry::init('Subscription');
	    }
      
      function testValidateName() {
        //not empty
        $data = array('Subscription' => array('name' => ''));
        $this->SubscriptionTest->set($data);
        $this->SubscriptionTest->validates();
        $this->assertNotNull($this->SubscriptionTest->validationErrors['name']);
        
        //max lenght 200
        //201
        $data = array('Subscription' => array('name' => '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567891'));
        $this->SubscriptionTest->set($data);
        $this->SubscriptionTest->validates();
        $this->assertNotNull($this->SubscriptionTest->validationErrors['name']);
        
        //200
        $data = array('Subscription' => array('name' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789'));
        $this->SubscriptionTest->set($data);
        $this->SubscriptionTest->validates();
        $this->assertFalse(array_key_exists('name',$this->SubscriptionTest->validationErrors));
      }
      
      function testValidateEmail() {
        //not empty
        $data = array('Subscription' => array('email' => ''));
        $this->SubscriptionTest->set($data);
        $this->SubscriptionTest->validates();
        $this->assertNotNull($this->SubscriptionTest->validationErrors['email']);
        
        //max lenght 200
        //201
        $data = array('Subscription' => array('email' => 'teste@67890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456.com'));
        $this->SubscriptionTest->set($data);
        $this->SubscriptionTest->validates();
        $this->assertNotNull($this->SubscriptionTest->validationErrors['email']);
        
        //200
        $data = array('Subscription' => array('title' => 'teste@6789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345.com'));
        $this->SubscriptionTest->set($data);
        $this->SubscriptionTest->validates();
        $this->assertFalse(array_key_exists('name',$this->SubscriptionTest->validationErrors));
        
        //invalid email
        $data = array('Subscription' => array('email' => 'teste@invalidemail'));
        $this->SubscriptionTest->set($data);
        $this->SubscriptionTest->validates();
        $this->assertNotNull($this->SubscriptionTest->validationErrors['email']);
        
        //isUnique
        $data = array('Subscription' => array('email' => 'someone@subscribed.com'));
        $this->SubscriptionTest->set($data);
        $this->SubscriptionTest->validates();
        $this->assertNotNull($this->SubscriptionTest->validationErrors['email']);
      }
      
      function testGroupAssociation() {
        $subscription = $this->SubscriptionTest->read(null, 1);
        $this->assertNotNull($subscription['Group']);
        $this->assertEqual('1', $subscription['Group'][0]['id']);
      }

  }
?>
