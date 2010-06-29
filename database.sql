
CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `episode_id` int(11) NOT NULL,
  `search` varchar(50) NOT NULL,
  `found` varchar(100) NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `episodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `series_id` int(11) NOT NULL,
  `ep_id` int(10) NOT NULL,
  `director` varchar(150) NOT NULL,
  `ep_img_flag` int(5) NOT NULL,
  `episode_name` varchar(150) NOT NULL,
  `episode` int(4) NOT NULL,
  `first_aired` date DEFAULT NULL,
  `guest_stars` varchar(200) NOT NULL,
  `IMDB_ID` varchar(30) NOT NULL,
  `language` varchar(4) NOT NULL,
  `overview` text NOT NULL,
  `rating` varchar(4) NOT NULL,
  `season` int(4) NOT NULL,
  `writer` varchar(150) NOT NULL,
  `filename` varchar(70) NOT NULL,
  `lastupdated` int(60) NOT NULL,
  `seasonid` int(10) NOT NULL,
  `seriesid` int(10) NOT NULL,
  `downloadable` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `abbreviation` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `languages` (`id`, `name`, `abbreviation`) VALUES
(10, 'Dansk', 'da'),
(11, 'Suomeksi', 'fi'),
(13, 'Nederlands', 'nl'),
(14, 'Deutsch', 'de'),
(15, 'Italiano', 'it'),
(16, 'Español', 'es'),
(17, 'Français', 'fr'),
(18, 'Polski', 'pl'),
(19, 'Magyar', 'hu'),
(20, 'Ελληνικά', 'el'),
(21, 'Türkçe', 'tr'),
(22, 'русский язык', 'ru'),
(24, ' עברית', 'he'),
(25, '日本語', 'ja'),
(26, 'Português', 'pt'),
(27, '中文', 'zh'),
(28, 'čeština', 'cs'),
(30, 'Slovenski', 'sl'),
(31, 'Hrvatski', 'hr'),
(32, '한국어', 'ko'),
(7, 'English', 'en'),
(8, 'Svenska', 'sv'),
(9, 'Norsk', 'no');

CREATE TABLE IF NOT EXISTS `rsses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `link` varchar(150) NOT NULL,
  `guid` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `pubDate` varchar(60) NOT NULL,
  `category` varchar(20) NOT NULL,
  `enclosure` varchar(400) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tvdb_id` int(10) NOT NULL,
  `actors` varchar(400) NOT NULL,
  `airs_day` varchar(10) NOT NULL,
  `airs_time` varchar(10) NOT NULL,
  `content_rating` varchar(10) NOT NULL,
  `first_aired` date NOT NULL,
  `genre` varchar(200) NOT NULL,
  `IMDB_ID` varchar(30) NOT NULL,
  `language` varchar(4) NOT NULL,
  `network` varchar(30) NOT NULL,
  `network_id` varchar(20) NOT NULL,
  `overview` text NOT NULL,
  `rating` varchar(5) NOT NULL,
  `runtime` int(5) NOT NULL,
  `series_id` int(10) NOT NULL,
  `series_name` varchar(150) NOT NULL,
  `status` varchar(10) NOT NULL,
  `added` datetime NOT NULL,
  `added_by` varchar(10) NOT NULL,
  `banner` varchar(60) NOT NULL,
  `fanart` varchar(60) NOT NULL,
  `lastupdated` int(20) NOT NULL,
  `poster` varchar(60) NOT NULL,
  `zap2it_id` varchar(10) NOT NULL,
  `matrix_cat` varchar(10) NOT NULL,
  `language_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


