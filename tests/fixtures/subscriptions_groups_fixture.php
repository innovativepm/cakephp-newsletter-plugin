<?php  
 class SubscriptionsGroupsFixture extends CakeTestFixture { 
    var $name = 'NewsletterSubscriptionsGroups'; 
    var $import = array('table' => 'newsletter_subscriptions_groups', 'import' => false);

    var $records = array( 
        array ('id' => '1',
        'newsletter_group_id' => '1',
        'newsletter_subscription_id' => '1'
        ),
        array ('id' => '2',
        'newsletter_group_id' => '1',
        'newsletter_subscription_id' => '2'
        ),
        array ('id' => '3',
        'newsletter_group_id' => '1',
        'newsletter_subscription_id' => '3'
        ),
    ); 
 } 
 ?> 
