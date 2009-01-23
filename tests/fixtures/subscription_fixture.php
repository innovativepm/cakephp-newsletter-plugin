<?php  
 class SubscriptionFixture extends CakeTestFixture { 
    var $name = 'NewsletterSubscription'; 
    var $import = array('table' => 'newsletter_subscriptions', 'import' => false);

    var $records = array( 
        array ('id' => 1, 
        'name' => 'Subscribed', 
        'email' => 'someone@subscribed.com',
        'opt_out_date' => null,
        'confirmation_code' => null, 
        'created' => '2008-12-03 14:30:00', 
        'modified' => '2008-12-03 14:30:00'), 
        
        array ('id' => 2, 
        'name' => 'Waiting Confirmation', 
        'email' => 'someone@waiting.com',
        'opt_out_date' => null,
        'confirmation_code' => 'some_code', 
        'created' => '2008-12-03 14:31:00', 
        'modified' => '2008-12-03 14:31:00'), 
        
        array ('id' => 3, 
        'name' => 'Opt Out', 
        'email' => 'opt@out.com',
        'opt_out_date' => '2008-12-03 14:32:00',
        'confirmation_code' => null, 
        'created' => '2008-12-03 14:32:00', 
        'modified' => '2008-12-03 14:32:00'),
        
        array ('id' => 4, 
        'name' => 'Subscription in Group 2', 
        'email' => 'group2@subscription.com',
        'opt_out_date' => null,
        'confirmation_code' => null, 
        'created' => '2008-12-03 14:33:00', 
        'modified' => '2008-12-03 14:33:00'),
        
        array ('id' => 5, 
        'name' => 'Subscription in Group 3', 
        'email' => 'group3@subscription.com',
        'opt_out_date' => '2008-12-03 14:30:00',
        'confirmation_code' => null, 
        'created' => '2008-12-03 14:34:00', 
        'modified' => '2008-12-03 14:34:00'),
        
        array ('id' => 6, 
        'name' => 'Other Person', 
        'email' => 'other@person.com',
        'opt_out_date' => null,
        'confirmation_code' => null, 
        'created' => '2008-12-03 14:35:00', 
        'modified' => '2008-12-03 14:35:00'),
    ); 
 } 
 ?> 
