<?php
  class Subscription extends NewsletterAppModel {

	  var $name = 'Subscription';
	  var $primaryKey = 'id';
    var $displayField = 'email';
    var $useTable = 'newsletter_subscriptions';
    
    var $actsAs   = array('extendAssociations'); 

    var $hasAndBelongsToMany = array(
				'Group' => array(
					'className' => 'Newsletter.Group',
					'joinTable' => 'newsletter_groups_subscriptions',
					'foreignKey' => 'newsletter_subscription_id',
					'associationForeignKey' => 'newsletter_group_id',
					'unique' => true,
				)
		);
    
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
		
		/**
		* Imports a Csv data array to the database.
		* @param $data In the pattern:
		*  array(
		    array[0] (
		      'email',
		      'name'
		    ),
		    array[1] (
		      'email2',
		      'name2'
		    )
		   )
		**/
		function importCsv($data) {
		  $this->insertMulti(array('email', 'name'),	$data); 			
		}
		
  }
?>
