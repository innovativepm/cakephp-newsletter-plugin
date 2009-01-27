<? 
$message = Configure::read('Newsletter.subscribe_message_text');
if($message) {
  if(!$url) {
    $url = "http://".$_SERVER['HTTP_HOST']."/newsletter/subscriptions/confirm_subscription/".$confirmation_code;
  } else {
    $url = "http://".$_SERVER['HTTP_HOST']."$url".$confirmation_code;
  }
  $message = str_replace('@@link@@', $url, $message);
  
  echo $message;
} else {
?>
  This is a message to confirm your solicitation to subscribe into our email list.
  To confirm the solicitation, please visit this link: http://<?php echo $_SERVER['HTTP_HOST'] ?>/newsletter/subscriptions/confirm_subscription/<?php echo $confirmation_code ?>
<?  
} 
?>
