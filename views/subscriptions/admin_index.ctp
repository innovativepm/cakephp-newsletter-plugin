<?php $paginator->url(array('admin' => true)); ?>

<ul class="actions">
  <li><?php echo $html->link(__('Add subscription', true), '/admin/newsletter/subscriptions/add', array('class' => 'button add')); ?></li>
</ul>

<div class="block">
    <h3><span><?php __( 'View subscriptions'); ?></span></h3>
    <table cellspacing="0">
        <thead>
            <tr>
                <th><?php echo $paginator->sort(__( 'Email', true), 'email'); ?></th>
                <th><?php echo $paginator->sort(__( 'Name', true), 'name'); ?></th>
                <th><?php echo $paginator->sort(__( 'Opt-Out', true), 'opt_out_date'); ?></th>
                <th><?php echo $paginator->sort(__( 'Created on', true), 'created'); ?></th>
	              <th><?php echo $paginator->sort(__( 'Modified on', true), 'modified'); ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php $i = 0; foreach($subscriptions as $subscription) : ?>
            <tr<?php echo is_int($i / 2) ? ' class="alt"' : ''; ?>>
                <td><?php echo $html->link($subscription['Subscription']['email'], array('action' => 'edit', 'admin' => true, $subscription['Subscription']['id'])); ?></td>
                <td><?php echo $subscription['Subscription']['name']; ?></td>
                <td><?php echo $subscription['Subscription']['opt_out_date']; ?> <?php echo $html->link(($subscription['Subscription']['opt_out_date'] ? __( '(unset)', true) : __( '(set)', true)), array('action' => 'invert_opt_out', 'admin' => true, $subscription['Subscription']['id'])); ?></td>
                <td><?php echo $time->niceShort($subscription['Subscription']['created']); ?></td>
	              <td><?php echo $time->niceShort($subscription['Subscription']['modified']); ?></td>
                <td><?php echo $html->link(__( 'Delete', true), array('action' => 'delete', 'admin' => true, $subscription['Subscription']['id'])); ?></td>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</div>

<?php echo $this->renderElement('admin_pagination'); ?>
