<?php 
  App::import('Model', 'Newsletter.GroupSubscription');

  class GroupSubscriptionCase extends CakeTestCase {

      var $fixtures = array('plugin.newsletter.mail', 'plugin.newsletter.mail_view', 'plugin.newsletter.groups_mails', 'plugin.newsletter.groups_subscriptions', 'plugin.newsletter.group', 'plugin.newsletter.subscription');
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
	    
	    function testExtractGroups() {
        $data = array('Group' => array(
            0 => array('id' => 5  ),
            1 => array('id' => 10),
            2 => array('id' => 15)
          )
        );
        
        $result = $this->GroupSubscriptionTest->extractGroups($data);
        $expected = array(5, 10, 15);
        $this->assertEqual($expected, $result);
        
        #test empty
        $data = array('Group' => array());
        
        $result = $this->GroupSubscriptionTest->extractGroups($data);
        $expected = array();
        $this->assertEqual($expected, $result);
      }
      
      function testRestingSubscriptions() {
        $rest = $this->GroupSubscriptionTest->restingSubscriptions(1, array('count' => true));
        $this->assertEqual(3, $rest);
        
        $rest = $this->GroupSubscriptionTest->restingSubscriptions(1);

        $this->assertEqual(3, count($rest));
        $this->assertEqual(2, $rest[0]['Subscription']['id']);
        $this->assertEqual(3, $rest[1]['Subscription']['id']);
        $this->assertEqual(4, $rest[2]['Subscription']['id']);
        
        $rest = $this->GroupSubscriptionTest->restingSubscriptions(1, array('limit' => 2));

        $this->assertEqual(2, count($rest));
        $this->assertEqual(2, $rest[0]['Subscription']['id']);
        $this->assertEqual(3, $rest[1]['Subscription']['id']);
      }
  }
?>
