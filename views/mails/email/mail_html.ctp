<?php echo $content ?>

<? 
$message = Configure::read('Newsletter.mail_opt_out_message');
if($message) {
  echo $message;
} else {
?>
  <div id="footer">
    <p>You are receiving this email because of you are into our mail list.</p>
    <p>If you don't want to receive our messages, please
    <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/newsletter/subscriptions/unsubscribe/<?php echo $confirmation_code ?>">click here</a>.</p>
  </div>
  <style type="text/css">
    div#rodape{
	    font-size:10px;
	    margin-top:15px;
	    line-height:normal
    }
  </style>
<?  
} 
?>

