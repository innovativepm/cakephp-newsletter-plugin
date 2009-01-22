<div class="block">
  <h3>
    <p><?php echo __('Sending mails...', true) ?>
    <?php echo $limit.__(' per time', true) ?></p>
  </h3>
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
</div>
