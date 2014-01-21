CREATE TABLE `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` varchar(20) NOT NULL,
  `service_id` varchar(20) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `begin` datetime NOT NULL,
  `end` datetime NOT NULL,
  `capacity` int(11) NOT NULL,
  `applicant` int(11) NOT NULL,
  `pref` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `place` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `is_delete` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;