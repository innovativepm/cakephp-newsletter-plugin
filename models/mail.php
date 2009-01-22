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
		
		function beforeValidate() {
		  #if groups has changed, reset the 'sent' and 'last_sent_subscription_id' fields
      if(array_key_exists('id', $this->data['Mail']) && array_key_exists('Group', $this->data) && array_key_exists('Group', $this->data['Group'])) {
        $current = $this->data;
		    $mail = $this->read(null, $current['Mail']['id']);
		    $this->set($current);
		    $new_groups = $current['Group']['Group'];
		    $old_groups = $this->extractGroups($mail);
        $diff = array_diff($new_groups, $old_groups);
        $diffBack = array_diff($old_groups, $new_groups);
        $diff = array_merge($diff, $diffBack);
		    if(!empty($diff)) {
		      $this->data['Mail']['sent'] = 0;
		      $this->data['Mail']['last_sent_subscription_id'] = 0;
		    }
		  }
		  return true;
		}
		
		function extractGroups($data) {
      $groups = array();
      
      if(!empty($data) && array_key_exists('Group', $data)) { 
        foreach ($data['Group'] as $key => $group) {
          if(is_numeric($key)) {
            array_push($groups, $group['id']);
          }
        }
      }
      return $groups;
    }
	}  
?>
