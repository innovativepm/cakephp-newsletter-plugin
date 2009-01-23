<?php echo $subscription['Subscription']['opt_out_date']; ?> <a href="#" onclick="changeOptOut(<?php echo $subscription['Subscription']['id'] ?>);"><?php echo ($subscription['Subscription']['opt_out_date'] ? __( '(unset)', true) : __( '(set)', true)) ?>
</a>



