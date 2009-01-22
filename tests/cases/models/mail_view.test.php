<?php 
  App::import('Model', 'Newsletter.MailView');

  class MailViewCase extends CakeTestCase {

      var $fixtures = array('plugin.newsletter.mail_view', 'plugin.newsletter.mail', 'plugin.newsletter.groups_mails', 'plugin.newsletter.groups_subscriptions', 'plugin.newsletter.group', 'plugin.newsletter.subscription');
      var $MailViewTest;
      
      function start() {
		    parent::start();
		    $this->MailViewTest = ClassRegistry::init('MailView');
	    }
	    
	    function testRelation() {
	      $relation = $this->MailViewTest->read(null, 1);
	      
	      $this->assertNotNull($relation);
	      $this->assertEqual(1, $relation['Mail']['id']);
	    }
	    
	    function testCountViews() {
	      $count = $this->MailViewTest->countViews(1);
	      $this->assertEqual(4, $count);
	      
	      $count = $this->MailViewTest->countViews(2);
	      $this->assertEqual(3, $count);
	    }
	    
	    function testCountUniqueViews() {
	      $count = $this->MailViewTest->countUniqueViews(1);
	      $this->assertEqual(3, $count);
	      
	      $count = $this->MailViewTest->countUniqueViews(2);
	      $this->assertEqual(2, $count);
	    }
  }
?>
