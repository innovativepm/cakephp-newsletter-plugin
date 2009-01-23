<?php $session->flash(); ?>
<?php echo $form->create('Mail', array('url' => $html->url(array('admin' => true, $this->data['Mail']['id'])))); ?>
<?php echo $form->input('Mail.id'); ?>
<?php echo $form->input('Mail.from', array('label' => __( 'From', true))); ?>
<?php echo $form->input('Mail.from_email', array('label' => __( 'From Email', true))); ?>
<?php echo $form->input('Mail.subject', array('label' => __( 'Subject', true))); ?>
<?php echo $form->input('Group') ?>
<?php echo $form->input('Mail.content', array('label' => __( 'Content', true), 'class' => 'htmlEditor')); ?>
<?php echo $form->end(__( 'Save', true)); ?>
<?php echo $html->link(__( 'Go back', true), array('action' => 'index', 'admin' => true)); ?>
