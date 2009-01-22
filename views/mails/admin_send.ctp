<div class="block">
  <h3>
    <p><?php echo __('Sending mails...', true) ?>
    <?php echo $limit.__(' per time', true) ?></p>
  </h3>
  <div id="updatable_table">
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
</div>
<script>

$(document).ready(function() {
	startInterval();
});

function startInterval() {
  //each x seconds, updates the 'updatable_table' div
	var interval = window.setInterval(callJob, <?php echo $interval * 1000 ?>);
}

function callJob() {
  var url = "<?= 'http://'.$_SERVER['HTTP_HOST'].'/admin/newsletter/mails/send_mail/'.$mail['Mail']['id'] ?>";
  $("#updatable_table").load(url);
}

</script>
