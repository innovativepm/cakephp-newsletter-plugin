<?php
	class Mail extends NewsletterAppModel { 
		
		var $name = 'Mail';
    var $primaryKey = 'id';
    var $displayField = 'name';
    var $useTable = 'newsletter_mails';
  
    var $actsAs   = array('extendAssociations'); 

    var $hasAndBelongsToMany = array(
				'Group' => array(
					'className' => 'Newsletter.Group',
					'joinTable' => 'newsletter_groups_mails',
					'foreignKey' => 'newsletter_mail_id',
					'associationForeignKey' => 'newsletter_group_id',
					'unique' => true,
				)
		);
  
		var $validate = array(
			'from' => array( 
					'notEmpty' => array(
					  'rule' => array('notEmpty'),
					  'message' => 'Required field.'
				  ),
					'maxLength' => array(
						'rule' => array('maxLength', 100),
						'message' => 'Too long.'
					)
			),
			'from_email' => array( 
					'email' => array(
						'rule' => array('email'),
						'allowEmpty' => false,
						'message' => 'Invalid Email'
					)
			),
			'subject' => array( 
					'notEmpty' => array(
					  'rule' => array('notEmpty'),
					  'message' => 'Required field.'
				  ),
					'maxLength' => array(
						'rule' => array('maxLength', 100),
						'message' => 'Too long.'
					)
			),
		);
	}  
?>
