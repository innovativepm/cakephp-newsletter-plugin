<?php
  class Subscription extends NewsletterAppModel {

	  var $name = 'Subscription';
	  var $primaryKey = 'id';
    var $displayField = 'email';
    var $useTable = 'newsletter_subscriptions';
    
    var $validate = array(
			'name' => array( 
	       'notEmpty' => array(
					  'rule' => array('notEmpty'),
					  'message' => 'Required field.'
				  ),
					'maxLength' => array(
						'rule' => array('maxLength', 200),
						'message' => 'Too long.'
					)
			),
			'email' => array( 
					'email' => array(
						'rule' => array('email'),
						'message' => 'Invalid email.'
					),
					'isUnique' => array(
						'rule' => 'isUnique',
						'message' => 'Email already subscribed.'					
					),
					'maxLength' => array(
						'rule' => array('maxLength', 200),
						'message' => 'Too long.'
					)
			)			
		);
  }
?>
