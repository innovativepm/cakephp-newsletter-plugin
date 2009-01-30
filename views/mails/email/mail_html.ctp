<?php
$header_message = Configure::read('Newsletter.mail_header_message');
$footer_message = Configure::read('Newsletter.mail_opt_out_message');

if(!$footer_message) {
  $footer_message = <<<HTML
  <div id="footer">
    <p>You are receiving this email because you are into our mail list.</p>
    <p>If you don't want to receive our messages, please
    <a href="@@link@@">click here</a>.</p>
  </div>
  <style type="text/css">
    div#footer{
	    font-size:10px;
	    margin-top:15px;
	    line-height:normal
    }
  </style> 
HTML;

}

if(!$url) {
  $url = "http://".$_SERVER['HTTP_HOST']."/newsletter/subscriptions/unsubscribe";
} else {
  $url = "http://".$_SERVER['HTTP_HOST']."$url";
}
$footer_message = str_replace('@@link@@', $url, $footer_message);

$content = str_replace('@@header@@', $header_message, $content);

if(strpos($content, '@@footer@@') === false) {
  echo $content;
  echo $footer_message;
} else {
  echo str_replace('@@footer@@', $footer_message ,$content);
}
?>

<img height='1px' width='1px' src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/newsletter/mails/read/<?php echo $readConfirmationCode ?>"/>

