<? 
$message = Configure::read('Newsletter.unsubscribe_message_text');
if($message) {
  echo $message;
} else {
?>
  This is a message to confirm your solicitation to get out from the email list.
  If you want to receive our emails again, please visit this link: http://<?php echo $_SERVER['HTTP_HOST'] ?>/newsletter/subscriptions/subscribe
<?  
} 
?>
