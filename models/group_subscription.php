<?php
	class GroupSubscription extends NewsletterAppModel { 
		
		var $name = 'GroupSubscription';
    var $primaryKey = 'id';
    var $useTable = 'newsletter_groups_subscriptions';
    var $Mail = null;
    
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

    /**
    * Returns the total resting subscriptions to receive a Mail.
    * This will only return the subscriptions into opt_in.
    * @param $mail_id The Mail id.
    * @param $options 
    * Accepts: 
    *   'count' => true - if you want the total resting subscriptions to send the Mail
    *   'limit' => number - if you want to limit the number of registries to fetch
    * @return
    *   if 'count' => true, return the total resting subscriptions to receive the Mail.
    *   else, returns the subscription data array resting to be sent, with the Subscription.id, Subscription.email, Subscription.name fields.
    * @access
    **/
    function restingSubscriptions($mail_id, $options=array()) {
      $this->Mail =& ClassRegistry::init('Newsletter.Mail'); 
    
      $mail = $this->Mail->read(null, $mail_id);
      $groups = $this->extractGroups($mail);
      $last_sent = $mail['Mail']['last_sent_subscription_id'];
      
      $fields = array('DISTINCT Subscription.id, Subscription.email, Subscription.name');
      $count = (is_array($options) && array_key_exists('count', $options) && $options['count']);
      if($count) {
        $fields = array('COUNT(DISTINCT Subscription.id) as count');
      }
      
      $limit = null;
      if(is_array($options) && array_key_exists('limit', $options) && $options['limit']) {
        $limit = $options['limit'];
      } 
      
      #unbind for performance gain
      $this->unbindModel(array('belongsTo' => array('Group')));
      
      $result = $this->find('all', array('fields' => $fields, 'conditions' => array('newsletter_group_id' => $groups, 'Subscription.id >' => $last_sent, 'Subscription.opt_out_date' => null), 'order' => 'Subscription.created', 'limit' => $limit));
      
       if($count) {
         return $result[0][0]['count'];
       }
       
       return $result;
    }
    
    function extractGroups($data) {
      $groups = array();
      
      if(!empty($data) && array_key_exists('Group', $data)) { 
        foreach ($data['Group'] as $key => $group) {
          array_push($groups, $group['id']);
        }
      }
      return $groups;
    }

	}  
?>
