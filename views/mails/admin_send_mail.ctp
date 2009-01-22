<?php if($rest == 0) { ?>
  <h2><?php echo __('Sending complete', true) ?></h2>
<?php } ?>
<table cellspacing="0">
  <thead>
    <tr>
      <th><?php echo __('Rest', true) ?></th>
      <th><?php echo __('Sent', true) ?></th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td><?php echo $rest ?></td>
      <td><?php echo $sent ?></td>
    </tr>
  </tbody>
</table>
