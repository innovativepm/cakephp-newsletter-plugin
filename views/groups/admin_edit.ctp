<?php $session->flash(); ?>
<?php echo $form->create('Group', array('url' => $html->url(array('admin' => true, $this->data['Group']['id'])))); ?>
<?php echo $form->input('Group.id'); ?>
<?php echo $form->input('Group.name', array('label' => __('Name', true))); ?>
<?php echo $form->end(__( 'Save', true)); ?>
<?php echo $html->link(__( 'Go back', true), array('action' => 'index', 'admin' => true)); ?>
