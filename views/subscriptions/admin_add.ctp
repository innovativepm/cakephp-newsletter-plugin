<?php echo $form->create('Subscription', array('url' => array( 'admin' => true ) ) ); ?>
<?php echo $form->input('Subscription.name', array('label' => __( 'Name', true))); ?>
<?php echo $form->input('Subscription.email', array('label' => __( 'Email', true))); ?>
<?php echo $form->input('Group', array('selected' => $siteGroup)) ?>
<?php echo $form->end(__( 'Save', true)); ?>
