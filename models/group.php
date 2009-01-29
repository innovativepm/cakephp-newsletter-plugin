<?php
/**
* Copyright (c) 2009, Fabio Kreusch
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
* @copyright            Copyright (c) 2009, Fabio Kreusch
* @link                 fabio.kreusch.com.br
* @license              http://www.opensource.org/licenses/mit-license.php The MIT License
*/
class Group extends NewsletterAppModel { 
	
	var $name = 'Group';
  var $primaryKey = 'id';
  var $displayField = 'name';
  var $useTable = 'newsletter_groups';

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
