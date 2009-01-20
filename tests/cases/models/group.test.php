<?php 
  App::import('Model', 'Newsletter.Group');

  class GroupCase extends CakeTestCase {

      var $fixtures = array('plugin.newsletter.group');
      var $GroupTest;
      
      function start() {
		    parent::start();
		    $this->GroupTest = ClassRegistry::init('Group');
	    }
      
      function testValidateName() {
        //not empty
        $data = array('Group' => array('name' => ''));
        $this->GroupTest->set($data);
        $this->GroupTest->validates();
        $this->assertNotNull($this->GroupTest->validationErrors['name']);
        
        //max lenght 100
        //101
        $data = array('Group' => array('name' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567891'));
        $this->GroupTest->set($data);
        $this->GroupTest->validates();
        $this->assertNotNull($this->GroupTest->validationErrors['name']);
        
        //100
        $data = array('Group' => array('name' => '0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789'));
        $this->GroupTest->set($data);
        $this->GroupTest->validates();
        $this->assertFalse(array_key_exists('name',$this->GroupTest->validationErrors));
      }

  }
?>
