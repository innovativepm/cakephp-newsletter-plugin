<?php $paginator->url(array('admin' => true)); ?>

<ul class="actions">
  <li><?php echo $html->link(__('Add group', true), '/admin/newsletter/groups/add', array('class' => 'button add')); ?></li>
</ul>

<div class="block">
    <h3><span><?php __( 'View groups'); ?></span></h3>
    <table cellspacing="0">
        <thead>
            <tr>
                <th><?php echo $paginator->sort(__( 'Name', true), 'name'); ?></th>
                <th><?php echo $paginator->sort(__( 'Created on', true), 'created'); ?></th>
	              <th><?php echo $paginator->sort(__( 'Modified on', true), 'modified'); ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php $i = 0; foreach($groups as $group) : ?>
            <tr<?php echo is_int($i / 2) ? ' class="alt"' : ''; ?>>
                <td><?php echo $html->link($group['Group']['name'], array('action' => 'edit', 'admin' => true, $group['Group']['id'])); ?></td>
                <td><?php echo $time->niceShort($group['Group']['created']); ?></td>
	              <td><?php echo $time->niceShort($group['Group']['modified']); ?></td>
                <td><?php echo $html->link(__( 'Delete', true), array('action' => 'delete', 'admin' => true, $group['Group']['id'])); ?></td>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</div>

<?php echo $this->renderElement('admin_pagination'); ?>
