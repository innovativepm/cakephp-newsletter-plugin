<div class="block">
  <h3><span><?php echo __( 'Statistics for ', true).$mail['Mail']['subject']; ?></span></h3>
  <table cellspacing="0">
    <tr>
      <td><?php echo __('Views: ', true) ?></td>
      <td><?php echo $count ?></td>
    </tr>
    <tr>
      <td><?php echo __('Unique views: ', true) ?></td>
      <td><?php echo $countUnique ?></td>
    </tr>
  </table>
</div>
<?php echo $html->link(__( 'Go back', true), array('action' => 'index', 'admin' => true)); ?>
