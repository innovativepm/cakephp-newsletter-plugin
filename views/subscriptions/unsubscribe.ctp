<?php echo $form->create('Subscription', array('url' => '/newsletter/subscriptions/unsubscribe' ) ); ?>
<?php echo $form->input('Subscription.email', array('label' => __( 'Email', true))); ?>
<?php echo $form->end(__( 'Save', true)); ?>
