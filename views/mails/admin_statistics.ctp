<div class="block">
  <h3><span><?php echo __( 'Statistics for ', true).$mail['Mail']['subject']; ?></span></h3>
    <table cellspacing="0">
      <thead>
        <tr>
          <th><?php echo __('Sent ', true) ?></th>
          <th><?php echo __('Rest ', true) ?></th>
          <th><?php echo __('Views ', true) ?></th>
          <th><?php echo __('Unique views: ', true) ?></th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td><?php echo $mail['Mail']['sent'] ?></td>
          <td><?php echo $rest ?></td>
          <td><?php echo $count ?></td>
          <td><?php echo $countUnique ?></td>
        </tr>
      </tbody>
    </table>
</div>
<?php echo $html->link(__( 'Go back', true), array('action' => 'index', 'admin' => true)); ?>
