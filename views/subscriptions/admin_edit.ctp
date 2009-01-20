<?php $session->flash(); ?>
<?php echo $form->create('Subscription', array('url' => $html->url(array('admin' => true, $this->data['Subscription']['id'])))); ?>
<?php echo $form->input('Subscription.id'); ?>
<?php echo $form->input('Subscription.name', array('label' => __('Name', true))); ?>
<?php echo $form->input('Subscription.email', array('label' => __('Email', true))); ?>
<?php echo $form->input('Group') ?>
<?php echo $form->end(__( 'Save', true)); ?>
<?php echo $html->link(__( 'Go back', true), array('action' => 'index', 'admin' => true)); ?>
