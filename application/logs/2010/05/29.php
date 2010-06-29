<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-05-29 15:34:06 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 15:35:49 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ MODPATH/database\classes\kohana\database\mysql.php [ 165 ]
2010-05-29 15:37:51 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ MODPATH/database\classes\kohana\database\mysql.php [ 165 ]
2010-05-29 15:38:36 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'GROUP BY
                    e.id
                LIMIT 1' at line 13 [ SELECT
                    e.first_aired AS next
                FROM
                    episodes e
                LEFT JOIN
                    serjoinep se ON se.episode_id = '24'
                LEFT JOIN
                    series s ON se.series_id = s.id
                WHERE
                    e.id > '24'
                ORDER BY
                    next DESC
                GROUP BY
                    e.id
                LIMIT 1 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-29 15:40:36 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'ORDER BY
                    next DESC
                GROUP BY
                ' at line 12 [ SELECT
                    e.first_aired AS next
                FROM
                    episodes e
                LEFT JOIN
                    serjoinep se ON se.episode_id = '24'
                LEFT JOIN
                    series s ON se.series_id = s.id
                WHERE
                    e.id > '24'
                LIMIT 1
                ORDER BY
                    next DESC
                GROUP BY
                    e.id ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-29 15:40:57 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'GROUP BY
                    e.id' at line 13 [ SELECT
                    e.first_aired AS next
                FROM
                    episodes e
                LEFT JOIN
                    serjoinep se ON se.episode_id = '24'
                LEFT JOIN
                    series s ON se.series_id = s.id
                WHERE
                    e.id > '24'
                ORDER BY
                    next DESC
                GROUP BY
                    e.id ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-29 15:41:12 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'GROUP BY
                    next' at line 13 [ SELECT
                    e.first_aired AS next
                FROM
                    episodes e
                LEFT JOIN
                    serjoinep se ON se.episode_id = '24'
                LEFT JOIN
                    series s ON se.series_id = s.id
                WHERE
                    e.id > '24'
                ORDER BY
                    next DESC
                GROUP BY
                    next ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-29 15:42:59 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ MODPATH/database\classes\kohana\database\mysql.php [ 165 ]
2010-05-29 15:56:26 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'episodes.series_id' in 'where clause' [ SELECT `episodes`.* FROM `episodes` WHERE `episodes`.`series_id` = '1' AND `first_aired` < 'CURDATE()' ORDER BY `first_aired` DESC ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-29 16:03:02 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'e.series_id' in 'where clause' [ SELECT
                    first_aired AS next
                FROM
                    episodes
                WHERE
                    id > '24' AND e.series_id = (SELECT series_id FROM episodes WHERE id = '24' LIMIT 1)
                ORDER BY
                    next DESC
                LIMIT 1 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-29 16:03:58 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:04:34 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:05:13 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:05:25 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:05:51 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:09:41 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:12:19 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:16:50 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:16:55 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:18:19 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:19:00 --- ERROR: ErrorException [ 1 ]: Call to undefined function curl_init() ~ APPPATH/classes\posters.php [ 76 ]
2010-05-29 16:19:17 --- ERROR: ErrorException [ 1 ]: Call to undefined function curl_init() ~ APPPATH/classes\posters.php [ 76 ]
2010-05-29 16:20:41 --- ERROR: ErrorException [ 1 ]: Call to undefined function curl_init() ~ APPPATH/classes\posters.php [ 76 ]
2010-05-29 16:21:36 --- ERROR: ReflectionException [ 0 ]: Method action_ajax_search does not exist ~ SYSPATH/classes\kohana\request.php [ 882 ]
2010-05-29 16:23:09 --- ERROR: Database_Exception [ 1103 ]: Incorrect table name '' [ INSERT INTO `` (`series_id`, `episode_id`) VALUES (32, 2512) ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-29 16:32:42 --- ERROR: Kohana_Exception [ 0 ]: The eries_id property does not exist in the Model_Episode class ~ MODPATH/orm\classes\kohana\orm.php [ 425 ]
2010-05-29 16:34:05 --- ERROR: ErrorException [ 2 ]: rename(images/__cache/80348-5.jpg,images/poster/80348-5.jpg) [function.rename]: No such file or directory ~ APPPATH/classes\controller\series.php [ 412 ]
2010-05-29 16:39:14 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:39:50 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:43:51 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:44:11 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:49:37 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:49:38 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:49:40 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 16:49:40 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 18:17:58 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 18:18:06 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 18:18:11 --- ERROR: ReflectionException [ 0 ]: Method action_episode does not exist ~ SYSPATH/classes\kohana\request.php [ 882 ]
2010-05-29 18:18:29 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 18:18:39 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 18:33:33 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 18:33:36 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 18:33:40 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 18:43:33 --- ERROR: OutOfBoundsException [ 0 ]: Seek position 0 is out of range ~ APPPATH/views\welcome\index.php [ 9 ]
2010-05-29 18:44:11 --- ERROR: OutOfBoundsException [ 0 ]: Seek position 0 is out of range ~ APPPATH/views\welcome\index.php [ 9 ]
2010-05-29 18:45:02 --- ERROR: OutOfBoundsException [ 0 ]: Seek position 0 is out of range ~ APPPATH/views\welcome\index.php [ 9 ]
2010-05-29 22:22:20 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'FROM
                series s
            LEFT JOIN
                episodes e O' at line 4 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
            FROM
                series s
            LEFT JOIN
                episodes e ON e.series_id = s.id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-29 22:23:09 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'FROM
                series s
            LEFT JOIN
                episodes e O' at line 4 [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
            FROM
                series s
            LEFT JOIN
                episodes e ON e.series_id = s.id
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-29 22:23:40 --- ERROR: ErrorException [ 8 ]: Undefined property: stdClass::$episode_id ~ APPPATH/views\welcome\index.php [ 35 ]
2010-05-29 22:26:13 --- ERROR: ErrorException [ 8 ]: Undefined property: stdClass::$next_episode ~ APPPATH/views\welcome\index.php [ 41 ]
2010-05-29 22:34:29 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/142 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-29 23:41:29 --- ERROR: ErrorException [ 1 ]: Class 'Model_Language' not found ~ MODPATH/orm\classes\kohana\orm.php [ 112 ]
2010-05-29 23:41:45 --- ERROR: Database_Exception [ 1146 ]: Table 'autotvtosab.languageses' doesn't exist [ SHOW FULL COLUMNS FROM `languageses` ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]