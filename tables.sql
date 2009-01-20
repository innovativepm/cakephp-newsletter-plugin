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

CREATE TABLE  `newsletter_subscriptions_groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `subscription_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
