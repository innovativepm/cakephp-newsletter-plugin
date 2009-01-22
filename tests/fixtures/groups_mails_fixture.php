<?php  
 class GroupsMailsFixture extends CakeTestFixture { 
    var $name = 'NewsletterGroupsMails'; 
    var $import = array('table' => 'newsletter_groups_mails', 'import' => false);

    var $records = array( 
        array ('id' => '1',
        'newsletter_group_id' => '1',
        'newsletter_mail_id' => '1'
        ),
        array ('id' => '2',
        'newsletter_group_id' => '2',
        'newsletter_mail_id' => '1'
        ),
        array ('id' => '3',
        'newsletter_group_id' => '1',
        'newsletter_mail_id' => '2'
        ),
    ); 
 } 
 ?> 
