<?php if(!$subscription['Subscription']['opt_out_date']) { ?>
  <?php echo __('Yes') ?>
<?php } else { ?>
  <?php echo __('No, at ') . $subscription['Subscription']['opt_out_date'] ?>
<?php } ?> 
<a href="#" onclick="changeOptOut(<?php echo $subscription['Subscription']['id'] ?>);"><?php echo ($subscription['Subscription']['opt_out_date'] ? __( '(unset)', true) : __( '(set)', true)) ?>
</a>



