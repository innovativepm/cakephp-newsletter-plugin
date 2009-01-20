<?php $paginator->url(array('admin' => true)); ?>

<ul class="actions">
  <li><?php echo $html->link(__('Add mail', true), '/admin/newsletter/mails/add', array('class' => 'button add')); ?></li>
</ul>

<div class="block">
    <h3><span><?php __( 'View mails'); ?></span></h3>
    <table cellspacing="0">
        <thead>
            <tr>
                <th><?php echo $paginator->sort(__( 'Subject', true), 'name'); ?></th>
                <th><?php echo $paginator->sort(__( 'Created on', true), 'created'); ?></th>
	              <th><?php echo $paginator->sort(__( 'Modified on', true), 'modified'); ?></th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php $i = 0; foreach($mails as $mail) : ?>
            <tr<?php echo is_int($i / 2) ? ' class="alt"' : ''; ?>>
                <td><?php echo $html->link($mail['Mail']['subject'], array('action' => 'edit', 'admin' => true, $mail['Mail']['id'])); ?></td>
                <td><?php echo $time->niceShort($mail['Mail']['created']); ?></td>
	              <td><?php echo $time->niceShort($mail['Mail']['modified']); ?></td>
                <td><?php echo $html->link(__( 'Delete', true), array('action' => 'delete', 'admin' => true, $mail['Mail']['id'])); ?></td>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</div>

<?php echo $this->renderElement('admin_pagination'); ?>
