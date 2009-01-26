<?php 
  App::import('Model', 'Newsletter.Subscription');

  class NewsletterAppModelCase extends CakeTestCase {

      var $fixtures = array('plugin.newsletter.groups_subscriptions', 'plugin.newsletter.group', 'plugin.newsletter.subscription');
      var $NewsletterAppModelTest;
      
      function start() {
		    parent::start();
		    $this->NewsletterAppModelTest = ClassRegistry::init('Subscription');
	    }
      
      function testEscape() {
        $string = 'teste';
        $this->assertEqual("'$string'", $this->NewsletterAppModelTest->escape($string));
      }
      
      function testInsertMulti() {
        $table = $this->NewsletterAppModelTest->useTable;
        $fields = array('email', 'name');
        $values = array(array('multi@multi.com','multi'), array('multi2@multi.com', 'multi2'), array('multi3@multi.com', 'multi3'));
        
        $this->NewsletterAppModelTest->insertMulti($table, $fields, $values);
        
        $found = $this->NewsletterAppModelTest->findByEmail('multi@multi.com');
        $this->assertEqual('multi', $found['Subscription']['name']);
        
        $found = $this->NewsletterAppModelTest->findByEmail('multi2@multi.com');
        $this->assertEqual('multi2', $found['Subscription']['name']);
        
        $found = $this->NewsletterAppModelTest->findByEmail('multi3@multi.com');
        $this->assertEqual('multi3', $found['Subscription']['name']);
      }
  }
?>
