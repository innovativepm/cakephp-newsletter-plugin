<?php 
  App::import('Model', 'Newsletter.GroupSubscription');

  class GroupSubscriptionCase extends CakeTestCase {

      var $fixtures = array('plugin.newsletter.groups_subscriptions', 'plugin.newsletter.group', 'plugin.newsletter.subscription');
      var $GroupSubscriptionTest;
      
      function start() {
		    parent::start();
		    $this->GroupSubscriptionTest = ClassRegistry::init('GroupSubscription');
	    }
	    
	    function testRelations() {
	      $relation = $this->GroupSubscriptionTest->read(null, 1);

	      $this->assertNotNull($relation);
	      $this->assertEqual(1, $relation['Subscription']['id']);
	      $this->assertEqual(1, $relation['Group']['id']);
	    }
  }
?>
