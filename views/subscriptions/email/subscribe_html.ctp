<? 
$message = Configure::read('Newsletter.subscribe_message_html');
if($message) {
  echo $message;
} else {
?>
  <p>This is a message to confirm your solicitation to subscribe into our email list.</p>
  <p>To confirm the solicitation, please
  <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/newsletter/subscriptions/confirm_subscription/<?php echo $confirmation_code ?>">click here</a>.</p>
<?  
} 
?>
