Requires:
Extend-Associations: http://bakery.cakephp.org/articles/view/add-delete-habtm-behavior
JQuery for ajax calls in admin_send.ctp

TODO Explain NewsletterAppController sendEmail() function

TODO Explain COnfiguration Fields
$subject = Configure::read('Newsletter.unsubscribe_subject');
$subject = Configure::read('Newsletter.subscribe_subject');
$from = Configure::read('Newsletter.from'); #Required
$from_email = Configure::read('Newsletter.from_email'); #Required

$subject = Configure::read('Newsletter.sendX'); #Number of emails to sent at each admin_send call.
$subject = Configure::read('Newsletter.sendInterval'); #the interval time before send next batch
$subject = Configure::read('Newsletter.mail_opt_out_message');
$subject = Configure::read('Newsletter.emptyImagePath');

