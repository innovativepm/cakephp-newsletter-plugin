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
class MailView extends NewsletterAppModel { 
	
	var $name = 'MailView';
  var $primaryKey = 'id';
  var $useTable = 'newsletter_mail_views';
  
  var $belongsTo = array(
      'Mail' => array(
          'className'    => 'Newsletter.Mail',
          'foreignKey'    => 'newsletter_mail_id'
      ),
  );
  
  /**
  * Returns the total number of views for a mail.
  * @param $mail_id The mail id.
  * @return The count result.
  **/
  function countViews($mail_id) {
    return $this->find('count', array('conditions' => array('MailView.newsletter_mail_id' => $mail_id)));	
  }  
  
  /**
  * Returns the total number of views for a mail, counting only unique IPs.
  * @param $mail_id The mail id.
  * @return The count result.
  **/
  function countUniqueViews($mail_id) {
    $count = $this->find('first', array('fields' => array("COUNT(DISTINCT MailView.ip) as 'count'"), 'conditions' => array('MailView.newsletter_mail_id' => $mail_id)));	
    return $count[0]['count'];
  }

}  
?>
