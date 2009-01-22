<?php  
 class MailFixture extends CakeTestFixture { 
    var $name = 'NewsletterMail'; 
    var $import = array('table' => 'newsletter_mails', 'import' => false);

    var $records = array( 
        array ('id' => 1, 
        'from' => 'Test From',
        'from_email' => 'test@from.com',
        'subject' => 'My Mail',
        'content' => 'Welcome!',
        'read_confirmation_code' => '12345',
        'last_sent_subscription_id' => '1', 
        'created' => '2008-12-03 14:30:00', 
        'modified' => '2008-12-03 14:30:00'),
        
        array ('id' => 2, 
        'from' => 'Test From',
        'from_email' => 'test@from.com',
        'subject' => 'Another Mail',
        'content' => 'Welcome!',
        'read_confirmation_code' => '123456', 
        'last_sent_subscription_id' => null, 
        'created' => '2008-12-03 14:31:00', 
        'modified' => '2008-12-03 14:31:00'),
    ); 
 } 
 ?> 
