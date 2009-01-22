Requires:
Extend-Associations: http://bakery.cakephp.org/articles/view/add-delete-habtm-behavior

TODO Explain NewsletterAppController sendEmail() function

TODO Explain COnfiguration Fields
$subject = Configure::read('Newsletter.unsubscribe_subject');
$subject = Configure::read('Newsletter.subscribe_subject');
$from = Configure::read('Newsletter.from'); #Required
$from_email = Configure::read('Newsletter.from_email'); #Required

$subject = Configure::read('Newsletter.sendX'); #Number of emails to sent at each admin_send call.

