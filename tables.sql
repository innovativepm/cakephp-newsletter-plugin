CREATE TABLE  `newsletter_subscriptions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(250) default NULL,
  `email` varchar(250) default NULL,
  `opt_out_date` datetime default NULL,
  `confirmation_code` varchar(250) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8

CREATE TABLE  `newsletter_groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(200) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE  `newsletter_groups_subscriptions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `newsletter_subscription_id` int(10) unsigned NOT NULL,
  `newsletter_group_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `Foreign_Keys` (`newsletter_subscription_id`,`newsletter_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8

CREATE TABLE  `newsletter_mails` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from` varchar(100) default NULL,
  `from_email` varchar(100) default NULL,
  `subject` varchar(100) default NULL,
  `content` text,
  `read_confirmation_code` varchar(100) default NULL,
  `last_sent_subscription_id` int(10) unsigned NOT NULL default '0',
  `sent` int(10) unsigned NOT NULL default '0',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8

CREATE TABLE  `newsletter_mail_views` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `newsletter_mail_id` int(10) unsigned default NULL,
  `ip` varchar(100) default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk` (`newsletter_mail_id`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8

CREATE TABLE  `newsletter_groups_mails` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `newsletter_mail_id` int(10) unsigned NOT NULL,
  `newsletter_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk` (`newsletter_mail_id`,`newsletter_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
