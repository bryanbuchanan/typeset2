# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Database: typset
# Generation Time: 2015-11-05 05:52:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table banner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `banner`;

CREATE TABLE `banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;

INSERT INTO `banner` (`id`, `title`, `image`, `url`, `tag`, `text`)
VALUES
	(1,'Client-side image resizing',NULL,NULL,'features','Images are resized client-side before they\'re uploaded, so large images can be used without having to worry about resource limits.'),
	(2,'Markdown text formatting',NULL,NULL,'features','Markdown text formatting to give users enough control to format their text, but not enough to make it ugly.'),
	(3,'Almost-inline editing',NULL,NULL,'features','Rather than a separate admin area, users can click on the content they\'d like to edit and do so right on the page.'),
	(4,'Crazy simple to use',NULL,NULL,'features','Have a stupid client that can\'t be trusted with a WordPress site? Perfect.'),
	(5,'Design-independent',NULL,NULL,'features','Widgets spit out compliant HTML without any styles, and all content\'s HTML can be edited.'),
	(6,'Non-intrusive',NULL,NULL,'features','You add it to your website, vs. having to adjust your workflow and build your website around the CMS.'),
	(8,'Dirt Rider Magazine','4317_image_202765-43.jpg','http://dirtrider.com','example_banners','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
	(9,'MiniMoto Magazine','4317_image_202763-14.jpg','http://google.com','example_banners','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
	(10,'Quad Magazine','4317_image_202761-35.jpg','http://quadmagazine.com','example_banners','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');

/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table blog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blog`;

CREATE TABLE `blog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `text` mediumtext,
  `tag` varchar(255) DEFAULT NULL,
  `urn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;

INSERT INTO `blog` (`id`, `date`, `title`, `image`, `text`, `tag`, `urn`)
VALUES
	(3,'2015-07-23 00:00:00','Blog Post Goes Here',NULL,'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','example_blog','blog-post-goes-here'),
	(4,'2015-07-27 10:23:08','Test',NULL,'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','example_blog','test-2'),
	(5,'2015-07-28 10:23:32','Blog Post Title',NULL,'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','example_blog','blog-post-title'),
	(6,'2015-07-28 10:23:39','Test Blog Post','_dsc3206-99.jpg','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','example_blog','test-blog-post');

/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table blurb
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blurb`;

CREATE TABLE `blurb` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `text` mediumtext,
  `tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `blurb` WRITE;
/*!40000 ALTER TABLE `blurb` DISABLE KEYS */;

INSERT INTO `blurb` (`id`, `title`, `image`, `text`, `tag`)
VALUES
	(2,NULL,NULL,'Typeset2 is a simple open-source content management system that can be added to most any bare-bones PHP website. It\'s ideal for small custom hand-made sites that need to allow the client to update small bits of content themselves.\r\n','intro'),
	(3,NULL,NULL,'1. Upload just the `html/edit` folder to the root level of the website.\r\n2. Create a new MySQL database by importing the `database_template.sql` file.\r\n3. Open \"edit/_settings.php\" and change the settings appropriately.\r\n4. Insert `<? include \"/edit/include.php\" ?>` at the top of any pages that should display managed content.\r\n5. Insert the appropriate \"widget\" in the pages where necessary (widgets are explained below).\r\n6. Edit your content with the admin area is accessible via `yourwebsite.com/edit`','installation'),
	(4,'About Us','_dsc3201-85.jpg','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.','example_blurb'),
	(6,NULL,NULL,'- Content templates are in the`/edit/templates` folder. Each content type has a minimal default template, but that can be overridden by creating a new template file and passing the \"template\" option to the class, pointing to your new file.\r\n- The title of a blog post can be grabbed with `<?= $typeset->post_title() ?>`, which is useful for things like `<title>` meta tags.','misc');

/*!40000 ALTER TABLE `blurb` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table credentials
# ------------------------------------------------------------

DROP TABLE IF EXISTS `credentials`;

CREATE TABLE `credentials` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table html
# ------------------------------------------------------------

DROP TABLE IF EXISTS `html`;

CREATE TABLE `html` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` mediumtext,
  `tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `html` WRITE;
/*!40000 ALTER TABLE `html` DISABLE KEYS */;

INSERT INTO `html` (`id`, `text`, `tag`)
VALUES
	(1,'<p>Any <strong>HTML</strong> will <em>work</em>. This is great for widgets, badges, embedded video etc.</p>\r\n\r\n<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/sb2Vofx_y48\" frameborder=\"0\" allowfullscreen></iframe>','html_example');

/*!40000 ALTER TABLE `html` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
