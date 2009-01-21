<?php  
 class GroupsSubscriptionsFixture extends CakeTestFixture { 
    var $name = 'NewsletterGroupsSubscriptions'; 
    var $import = array('table' => 'newsletter_groups_subscriptions', 'import' => false);

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
        array ('id' => '4',
        'newsletter_group_id' => '2',
        'newsletter_subscription_id' => '4'
        ),
    ); 
 } 
 ?> 
