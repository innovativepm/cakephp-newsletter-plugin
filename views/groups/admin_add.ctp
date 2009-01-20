<?php echo $form->create('Group', array('url' => array( 'admin' => true ) ) ); ?>
<?php echo $form->input('Group.name', array('label' => __( 'Name', true))); ?>
<?php echo $form->end(__( 'Save', true)); ?>
