<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-05-18 07:50:06 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:52:04 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:53:11 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:53:16 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:53:25 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:53:29 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:53:36 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:53:41 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:53:58 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:54:21 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:54:30 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:54:39 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:54:43 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:54:49 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:54:55 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:54:58 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 07:55:20 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:01:47 --- ERROR: ErrorException [ 8 ]: Undefined property: stdClass::$episodes ~ APPPATH/views\welcome\index.php [ 13 ]
2010-05-18 12:02:06 --- ERROR: ErrorException [ 8 ]: Undefined property: stdClass::$episodes ~ APPPATH/views\welcome\index.php [ 13 ]
2010-05-18 12:02:12 --- ERROR: ErrorException [ 8 ]: Undefined property: stdClass::$episode ~ APPPATH/views\welcome\index.php [ 13 ]
2010-05-18 12:03:08 --- ERROR: ErrorException [ 8 ]: Undefined property: stdClass::$episodes ~ APPPATH/views\welcome\index.php [ 13 ]
2010-05-18 12:03:31 --- ERROR: ErrorException [ 8 ]: Undefined property: stdClass::$episodes ~ APPPATH/views\welcome\index.php [ 13 ]
2010-05-18 12:10:09 --- ERROR: ErrorException [ 1 ]: Call to undefined method Database_MySQL_Result::where() ~ APPPATH/views\welcome\index.php [ 14 ]
2010-05-18 12:10:27 --- ERROR: ErrorException [ 1 ]: Call to undefined method Database_MySQL_Result::where() ~ APPPATH/views\welcome\index.php [ 14 ]
2010-05-18 12:10:37 --- ERROR: ErrorException [ 1 ]: Call to undefined method Database_MySQL_Result::where() ~ APPPATH/views\welcome\index.php [ 14 ]
2010-05-18 12:12:05 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_MySQL_Result::$episodes ~ APPPATH/views\welcome\index.php [ 14 ]
2010-05-18 12:12:54 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_MySQL_Result::$episodes ~ APPPATH/views\welcome\index.php [ 14 ]
2010-05-18 12:13:17 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_MySQL_Result::$episodes ~ APPPATH/views\welcome\index.php [ 14 ]
2010-05-18 12:14:04 --- ERROR: Kohana_Exception [ 0 ]: The episodes property does not exist in the Model_Episode class ~ MODPATH/orm\classes\kohana\orm.php [ 373 ]
2010-05-18 12:14:25 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'series_id' in 'where clause' [ SELECT `episodes`.* FROM `episodes` WHERE `series_id` = '7' ORDER BY `episodes`.`id` ASC ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 12:17:21 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_MySQL_Result::$id ~ APPPATH/views\welcome\index.php [ 14 ]
2010-05-18 12:17:49 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_MySQL_Result::$id ~ APPPATH/views\welcome\index.php [ 14 ]
2010-05-18 12:18:05 --- ERROR: ErrorException [ 1 ]: Call to undefined method Database_MySQL_Result::count_all() ~ APPPATH/views\welcome\index.php [ 14 ]
2010-05-18 12:23:12 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:29:53 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:31:23 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:31:33 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:48:13 --- ERROR: ErrorException [ 2 ]: rename(images/__cache/75382-5.jpg,images/poster/75382-5.jpg) [function.rename]: No error ~ APPPATH/classes\controller\series.php [ 406 ]
2010-05-18 12:57:03 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:58:38 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:58:45 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:58:53 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:59:41 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 12:59:55 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 13:00:01 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 13:00:04 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 13:01:15 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 13:04:44 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'e.first_aired AS ep_aired
            FROM
                series s
            ' at line 7 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea
                e.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 13:20:39 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 13:23:02 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 13:23:09 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 13:23:14 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 17:47:54 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: favicon.ico ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:00:20 --- ERROR: Kohana_Exception [ 0 ]: Not an image or invalid image: DOCROOT/images\__cache\83123-1.jpg ~ MODPATH/image\classes\kohana\image.php [ 96 ]
2010-05-18 18:03:03 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:03:42 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:03:44 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:04:05 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:04:14 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:04:30 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:04:39 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:04:50 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:04:52 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:05:25 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:05:39 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:05:53 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:05:54 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:05:57 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:06:30 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:06:51 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:07:05 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:07:08 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:07:13 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:07:24 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:07:27 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:09:06 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:09:11 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:09:34 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:09:37 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:09:43 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:09:46 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:09:53 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:10:18 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:10:20 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:10:31 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:10:41 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:10:52 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:11:03 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:11:11 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:11:19 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:11:39 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:11:43 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:12:11 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:12:30 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:12:56 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:13:05 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:13:09 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:13:24 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:13:26 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:13:43 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:13:47 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:14:04 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:14:05 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:14:06 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:14:19 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:14:25 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:14:39 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:14:43 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:15:39 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:15:45 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:15:57 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:16:05 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:16:15 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:18:14 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:18:28 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ APPPATH/classes\posters.php [ 80 ]
2010-05-18 18:18:56 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:19:03 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:19:13 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:19:23 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:20:29 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:20:33 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:20:46 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 18:20:54 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:06:58 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:07:10 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:07:17 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:07:35 --- ERROR: ErrorException [ 2 ]: file_get_contents(http://nzbmatrix.com/api-nzb-search.php?search=Glee+S01E19&amp;catid=6&amp;num=5&amp;age=&amp;region=&amp;group=&amp;username=morre95&amp;apikey=c9f6b98125730454b47fcc3b5385916e) [function.file-get-contents]: failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found
 ~ APPPATH/classes\nzbMatrix.php [ 28 ]
2010-05-18 19:07:42 --- ERROR: ErrorException [ 2 ]: file_get_contents(http://nzbmatrix.com/api-nzb-search.php?search=Glee+S01E19&amp;catid=6&amp;num=5&amp;age=&amp;region=&amp;group=&amp;username=morre95&amp;apikey=c9f6b98125730454b47fcc3b5385916e) [function.file-get-contents]: failed to open stream: HTTP request failed! HTTP/1.1 404 Not Found
 ~ APPPATH/classes\nzbMatrix.php [ 28 ]
2010-05-18 19:08:38 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:40:12 --- ERROR: Kohana_Exception [ 0 ]: Not an image or invalid image:  ~ MODPATH/image\classes\kohana\image.php [ 96 ]
2010-05-18 19:40:12 --- ERROR: Kohana_Exception [ 0 ]: Not an image or invalid image:  ~ MODPATH/image\classes\kohana\image.php [ 96 ]
2010-05-18 19:41:14 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:44:04 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:44:04 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:44:40 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:44:55 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:45:08 --- ERROR: Kohana_Exception [ 0 ]: Not an image or invalid image: DOCROOT/images\__cache\83123-1.jpg ~ MODPATH/image\classes\kohana\image.php [ 96 ]
2010-05-18 19:46:30 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:50:57 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:51:09 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:51:43 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:52:06 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:52:33 --- ERROR: ErrorException [ 2 ]: simplexml_load_file() [function.simplexml-load-file]: http://www.thetvdb.com/api/GetSeries.php?seriesname=Entourage&amp;language=all:1: parser error : Start tag expected, '&lt;' not found ~ APPPATH/classes\tv\info.php [ 30 ]
2010-05-18 19:54:21 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:54:50 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:54:51 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:55:10 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:55:17 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:55:19 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:55:35 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:55:43 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:55:51 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:56:04 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:56:22 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:56:25 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:56:28 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:56:35 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:56:55 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:57:05 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:57:12 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:57:19 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:57:38 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:57:42 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:58:14 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:58:52 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:58:56 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:59:06 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:59:27 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:59:47 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 19:59:51 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 20:00:06 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 20:00:23 --- ERROR: InvalidArgumentException [ 0 ]: Error: No image at: http://thetvdb.com/banners/episodes/70851/373181.jpg. Msg: couldn't connect to host ~ APPPATH/classes\posters.php [ 82 ]
2010-05-18 20:33:02 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'last_aired' in 'order clause' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            INNER JOIN
            episodes ep ON se.episode_id =
            (
            SELECT
                id
            FROM
                episodes
            WHERE
                id = se.episode_id
            ORDER BY
                last_aired DESC
            LIMIT 1
            )
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 20:33:22 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'last_aired' in 'order clause' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            INNER JOIN
            episodes ep ON se.episode_id =
            (
            SELECT
                id
            FROM
                episodes
            WHERE
                id = se.episode_id
            ORDER BY
                last_aired DESC
            LIMIT 1
            )
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 20:34:07 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'ep.last_aired' in 'order clause' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            INNER JOIN
            episodes ep ON se.episode_id =
            (
            SELECT
                id
            FROM
                episodes
            WHERE
                id = se.episode_id
            ORDER BY
                ep.last_aired DESC
            LIMIT 1
            )
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 20:35:24 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-18 22:14:42 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'last_aired' in 'on clause' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id

            INNER JOIN
                episodes ep ON last_aired =
                (
                SELECT
                    first_aired
                FROM
                    episodes
                WHERE
                    first_aired = last_aired
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
                
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:15:14 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'last_aired' in 'on clause' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id

            INNER JOIN
                episodes ep ON last_aired =
                (
                SELECT
                    first_aired
                FROM
                    episodes
                
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
                
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:15:42 --- ERROR: Database_Exception [ 1111 ]: Invalid use of group function [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id

            INNER JOIN
                episodes ep ON MAX(e.first_aired) =
                (
                SELECT
                    first_aired
                FROM
                    episodes
                
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
                
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:17:21 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-18 22:17:40 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'ep.episode' in 'field list' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id

            
                
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:21:13 --- ERROR: Database_Exception [ 1241 ]: Operand should contain 1 column(s) [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id

            INNER JOIN
                episodes ep ON ep.id =
                (
                SELECT
                    id,
                    MAX(first_aired) AS last_aired
                FROM
                    episodes
                WHERE
                    id = e.id
                ORDER BY
                    last_aired DESC
                LIMIT 1
                )
                
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:21:47 --- ERROR: Database_Exception [ 1241 ]: Operand should contain 1 column(s) [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id

            INNER JOIN
                episodes ep ON ep.id =
                (
                SELECT
                    id,
                    MAX(first_aired) AS last_air
                FROM
                    episodes
                WHERE
                    id = e.id
                ORDER BY
                    last_air DESC
                LIMIT 1
                )
                
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:27:18 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-18 22:32:33 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'ep.episode' in 'field list' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            WHERE
               last_aired =
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:32:52 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'last_aired' in 'where clause' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            WHERE
               last_aired =
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:32:53 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'last_aired' in 'where clause' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            WHERE
               last_aired =
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:33:47 --- ERROR: Database_Exception [ 1111 ]: Invalid use of group function [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            WHERE
               MAX(e.first_aired) =
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:36:46 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(
                SELECT
                    MAX(first_aired)
                FR' at line 10 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                ) AS ep
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:37:21 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(
                SELECT
                    first_aired
                FROM
  ' at line 10 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
                (
                SELECT
                    first_aired
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                ) AS ep
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:38:10 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(
                SELECT
                    MAX(first_aired)
                FR' at line 10 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                ) AS ep
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:38:31 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(
                SELECT
                    MAX(first_aired)
                FR' at line 10 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                ) ep
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:38:43 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(
                SELECT
                    MAX(first_aired)
                FR' at line 10 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                ) AS ep
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:38:51 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(
                SELECT
                    MAX(first_aired)
                FR' at line 10 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:39:00 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(
                SELECT
                    MAX(first_aired)
                FR' at line 10 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series AS s
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:39:09 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(
                SELECT
                    MAX(first_aired)
                FR' at line 10 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series AS s
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                ) AS ep
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:39:34 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'e.id' in 'where clause' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s,
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                WHERE
                    id = e.id
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                ) AS ep
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:40:26 --- ERROR: Database_Exception [ 1054 ]: Unknown column 's.id' in 'on clause' [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s,
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes

                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                ) AS ep
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:41:31 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 22:41:40 --- ERROR: Database_Exception [ 1242 ]: Subquery returns more than 1 row [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            WHERE
               e.first_aired =
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                )
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:43:00 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '(
                SELECT
                    MAX(first_aired)
                FR' at line 16 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                e.episode AS ep_num,
                e.id AS ep_id,
                e.season AS ep_sea,
                e.first_aired AS ep_aired
            FROM
                series s
            LEFT JOIN
                serjoinep se ON se.series_id = s.id
            LEFT JOIN
                episodes e ON e.id = se.episode_id
            LEFT JOIN
               e.first_aired =
                (
                SELECT
                    MAX(first_aired)
                FROM
                    episodes
                GROUP BY
                    id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:46:42 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-18 22:52:00 --- ERROR: Kohana_Exception [ 0 ]: Invalid method getPreviousAired called in Model_Episode ~ MODPATH/orm\classes\kohana\orm.php [ 293 ]
2010-05-18 22:52:41 --- ERROR: Database_Exception [ 1054 ]: Unknown column 's.id' in 'group statement' [ SELECT
                e.*,
                MAX(e.first_aired) AS last_aired
            FROM
                episodes e
            LEFT JOIN
                serjoinep se ON se.series_id = 14 AND se.episode_id = e.id
            WHERE
                e.first_aired < NOW()
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                1 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-18 22:53:58 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ MODPATH/database\classes\kohana\database\mysql.php [ 165 ]
2010-05-18 22:58:36 --- ERROR: Kohana_Exception [ 0 ]: Invalid method getPreviousAired called in Model_Episode ~ MODPATH/orm\classes\kohana\orm.php [ 293 ]
2010-05-18 22:59:03 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ MODPATH/database\classes\kohana\database\mysql.php [ 165 ]
2010-05-18 22:59:33 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 22:59:49 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 22:59:53 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 23:01:29 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 23:01:43 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 23:01:50 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-18 23:01:54 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]