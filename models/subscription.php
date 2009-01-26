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
		  @param $groups An array with the groups the imported users should be added to.
		**/
		function importCsv($data, $groups=array()) {
		  $this->insertMulti(array('email', 'name'),	$data); 	
		  
		  if(!empty($groups)) {
		    $emails = array();
		    foreach ($data as $value) {
		      array_push($emails, $value[0]);
		    }
		    
		    $this->unbindModel(array('hasAndBelongsToMany' => array('Group')));
		    $ids = $this->find('all', array('fields' => array('id'), 'conditions' => array('email' => $emails)));
		    
		    $values = array();
		    foreach ($ids as $id) {
		      foreach ($groups as $group_id) {
		        array_push($values, array($id['Subscription']['id'], $group_id));
		      }
		    }
		    
		    $this->insertMulti(array('newsletter_subscription_id', 'newsletter_group_id'),	$values, 'newsletter_groups_subscriptions');
		  }	
		}
		
  }
?>
