<?php
	class Group extends NewsletterAppModel { 
		
		var $name = 'Group';
    var $primaryKey = 'id';
    var $displayField = 'name';
    var $useTable = 'newsletter_groups';

		var $actsAs   = array('extendAssociations');

		var $validate = array(
			'name' => array( 
					'notEmpty' => array(
					  'rule' => array('notEmpty'),
					  'message' => 'Required field.'
				  ),
					'maxLength' => array(
						'rule' => array('maxLength', 100),
						'message' => 'Too long.'
					)
			)
		);
	}  
?>
