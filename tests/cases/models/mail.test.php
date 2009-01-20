<?php 
  App::import('Model', 'Newsletter.Mail');

  class MailCase extends CakeTestCase {

      var $fixtures = array('plugin.newsletter.mail');
      var $MailTest;
      
      function start() {
		    parent::start();
		    $this->MailTest = ClassRegistry::init('Mail');
	    }
      
      function testValidateFrom() {
        //not empty
        $data = array('Mail' => array('from' => ''));
        $this->MailTest->set($data);
        $this->MailTest->validates();
        $this->assertNotNull($this->MailTest->validationErrors['from']);
        
        //max lenght 100
        //101
        $data = array('Mail' => array('from' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567891'));
        $this->MailTest->set($data);
        $this->MailTest->validates();
        $this->assertNotNull($this->MailTest->validationErrors['from']);
        
        //100
        $data = array('Mail' => array('from' => '0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789'));
        $this->MailTest->set($data);
        $this->MailTest->validates();
        $this->assertFalse(array_key_exists('from',$this->MailTest->validationErrors));
      }
      
      function testValidateFromEmail() {
        //not empty
        $data = array('Mail' => array('from_email' => ''));
        $this->MailTest->set($data);
        $this->MailTest->validates();
        $this->assertNotNull($this->MailTest->validationErrors['from_email']);
        
        //invalid email
        $data = array('Mail' => array('from_email' => 'invalid_email'));
        $this->MailTest->set($data);
        $this->MailTest->validates();
        $this->assertNotNull($this->MailTest->validationErrors['from_email']);
        
        //valid email
        $data = array('Mail' => array('from_email' => 'test@test.com'));
        $this->MailTest->set($data);
        $this->MailTest->validates();
        $this->assertFalse(array_key_exists('from_email',$this->MailTest->validationErrors));
      }
      
      function testValidateSubject() {
        //not empty
        $data = array('Mail' => array('subject' => ''));
        $this->MailTest->set($data);
        $this->MailTest->validates();
        $this->assertNotNull($this->MailTest->validationErrors['subject']);
        
        //max lenght 100
        //101
        $data = array('Mail' => array('subject' => '01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567891'));
        $this->MailTest->set($data);
        $this->MailTest->validates();
        $this->assertNotNull($this->MailTest->validationErrors['subject']);
        
        //100
        $data = array('Mail' => array('subject' => '0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789'));
        $this->MailTest->set($data);
        $this->MailTest->validates();
        $this->assertFalse(array_key_exists('subject',$this->MailTest->validationErrors));
      }

  }
?>
