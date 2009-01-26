<?php 
  App::import('Model', 'Newsletter.Subscription');
  App::import('Model', 'Newsletter.Group');

  class SubscriptionCase extends CakeTestCase {

      var $fixtures = array('plugin.newsletter.groups_subscriptions', 'plugin.newsletter.group', 'plugin.newsletter.subscription');
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
      
      function testHABTMBehaviour() {
        $this->SubscriptionTest->habtmAdd('Group', 1, 2);
        
        $subscription = $this->SubscriptionTest->read(null, 1);
        $this->assertNotNull($subscription['Group']);
        $this->assertEqual('1', $subscription['Group'][0]['id']);
        $this->assertEqual('2', $subscription['Group'][1]['id']);
        
        $this->SubscriptionTest->habtmDelete('Group', 1, 2);
        
        $subscription = $this->SubscriptionTest->read(null, 1);
        $this->assertNotNull($subscription['Group']);
        $this->assertEqual('1', $subscription['Group'][0]['id']);
        $this->assertFalse(array_key_exists(1, $subscription['Group']));
      }
      
      function testImportCsv() {
        $table = $this->SubscriptionTest->useTable;
        $fields = array('email', 'name');
        $values = array(array('multi@multi.com','multi'), array('multi2@multi.com', 'multi2'), array('multi3@multi.com', 'multi3'));
        
        $this->SubscriptionTest->importCsv($values);
        
        $found = $this->SubscriptionTest->findByEmail('multi@multi.com');
        $this->assertEqual('multi', $found['Subscription']['name']);
        
        $found = $this->SubscriptionTest->findByEmail('multi2@multi.com');
        $this->assertEqual('multi2', $found['Subscription']['name']);
        
        $found = $this->SubscriptionTest->findByEmail('multi3@multi.com');
        $this->assertEqual('multi3', $found['Subscription']['name']);
      }

  }
?>
