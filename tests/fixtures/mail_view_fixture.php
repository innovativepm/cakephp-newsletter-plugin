<?php  
 class MailViewFixture extends CakeTestFixture { 
    var $name = 'NewsletterMailView'; 
    var $import = array('table' => 'newsletter_mail_views', 'import' => false);

    var $records = array( 
        array ('id' => 1, 
        'newsletter_mail_id' => 1,
        'ip' => '1234',
        'created' => '2008-12-03 14:30:00', ),
        
        array ('id' => 2, 
        'newsletter_mail_id' => 1,
        'ip' => '1234',
        'created' => '2008-12-03 14:30:00', ),
        
        array ('id' => 3, 
        'newsletter_mail_id' => 1,
        'ip' => '123456',
        'created' => '2008-12-03 14:30:00', ),
        
        array ('id' => 4, 
        'newsletter_mail_id' => 1,
        'ip' => '1234567',
        'created' => '2008-12-03 14:30:00', ),
        
        array ('id' => 5, 
        'newsletter_mail_id' => 2,
        'ip' => '1234567',
        'created' => '2008-12-03 14:30:00', ),
        
        array ('id' => 6, 
        'newsletter_mail_id' => 2,
        'ip' => '1234567',
        'created' => '2008-12-03 14:30:00', ),
        
        array ('id' => 7, 
        'newsletter_mail_id' => 2,
        'ip' => '12',
        'created' => '2008-12-03 14:30:00', ),
    ); 
 } 
 ?> 
