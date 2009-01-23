<? 
$message = Configure::read('Newsletter.unsubscribe_message_html');
if($message) {
  $url = "http://".$_SERVER['HTTP_HOST']."/newsletter/subscriptions/subscribe";
  $message = str_replace('@@link@@', $url, $message);
  echo $message;
} else {
?>
  <p>This is a message to confirm your solicitation to get out from the email list.</p>
  <p>If you want to receive our emails again, please 
  <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/newsletter/subscriptions/subscribe">click here</a>.</p>
<?  
} 
?>
