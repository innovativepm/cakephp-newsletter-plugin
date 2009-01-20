<?php  
 class GroupFixture extends CakeTestFixture { 
    var $name = 'NewsletterGroup'; 
    var $import = array('table' => 'newsletter_groups', 'import' => false);

    var $records = array( 
        array ('id' => 1, 
        'name' => 'Main Group', 
        'created' => '2008-12-03 14:30:00', 
        'modified' => '2008-12-03 14:30:00'),
         
        array ('id' => 2, 
        'name' => 'Secondary Group', 
        'created' => '2008-12-03 14:30:00', 
        'modified' => '2008-12-03 14:30:00'), 
    ); 
 } 
 ?> 
