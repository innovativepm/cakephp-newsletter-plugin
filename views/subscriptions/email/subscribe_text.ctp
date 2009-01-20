<? 
$message = Configure::read('Newsletter.subscribe_message_text');
if($message) {
  echo $message;
} else {
?>
  This is a message to confirm your solicitation to subscribe into our email list.
  To confirm the solicitation, please visit this link: http://<?php echo $_SERVER['HTTP_HOST'] ?>/newsletter/subscriptions/confirm_subscription/<?php echo $confirmation_code ?>
<?  
} 
?>
