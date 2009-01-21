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
		* Save many subscriptions in batch (as data read from a csv file).
		* @param $data An array with data to be inserted (the same needed for a saveAll() call).
		* @return True if everything ok
		**/
		/*function saveSubscriptionsBatchMode($data) {
		  $table_name = $this->useTable;
		  $sql = "LOCK TABLES `$table_name` WRITE;";
		  foreach ($data as $key => $value)  {
        $email = $value[$this->name]['email'];
        $name = $value[$this->name]['name'];
        
        $sql .= "INSERT INTO `$table_name` (email, name) VALUES ('$email', '$name');";
		  }
		  $sql .= "UNLOCK TABLES;";
		  $this->query($sql);
		  #debug($sql);
		}*/
  }
?>
