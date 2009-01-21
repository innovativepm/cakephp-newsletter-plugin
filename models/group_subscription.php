<?php
	class GroupSubscription extends NewsletterAppModel { 
		
		var $name = 'GroupSubscription';
    var $primaryKey = 'id';
    var $useTable = 'newsletter_groups_subscriptions';
    
    var $belongsTo = array(
        'Subscription' => array(
            'className'    => 'Newsletter.Subscription',
            'foreignKey'    => 'newsletter_subscription_id'
        ),
        'Group' => array(
            'className'    => 'Newsletter.Group',
            'foreignKey'    => 'newsletter_group_id'
        )
    );  

	}  
?>
