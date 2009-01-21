<?php $paginator->url(array('admin' => true)); ?>

<div class="block">
    <h3><span><?php echo __( 'View subscriptions in group: ').$group['Group']['name']; ?></span></h3>
    <table cellspacing="0">
        <thead>
            <tr>
                <th><?php echo $paginator->sort(__( 'Email', true), 'name'); ?></th>
                <th><?php echo $paginator->sort(__( 'Name', true), 'name'); ?></th>
                <th><?php echo $paginator->sort(__( 'Created on', true), 'created'); ?></th>
	              <th><?php echo $paginator->sort(__( 'Modified on', true), 'modified'); ?></th>
            </tr>
        </thead>

        <tbody>
            <?php $i = 0; foreach($subscriptions as $subcription) : ?>
            <tr<?php echo is_int($i / 2) ? ' class="alt"' : ''; ?>>
                <td><?php echo $html->link($subcription['Subscription']['email'], array('controller' => 'subscriptions', 'action' => 'edit', 'admin' => true, $subcription['Subscription']['id'])); ?></td>
                <td><?php echo $subcription['Subscription']['name']; ?></td>
                <td><?php echo $time->niceShort($subcription['Subscription']['created']); ?></td>
	              <td><?php echo $time->niceShort($subcription['Subscription']['modified']); ?></td>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</div>

<?php echo $this->renderElement('admin_pagination'); ?>
