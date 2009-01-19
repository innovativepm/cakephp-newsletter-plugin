<?php echo $form->create('Subscription', array('url' => '/newsletter/subscriptions/subscribe' ) ); ?>
<?php echo $form->input('Subscription.name', array('label' => __( 'Name', true))); ?>
<?php echo $form->input('Subscription.email', array('label' => __( 'Email', true))); ?>
<?php echo $form->end(__( 'Save', true)); ?>
