<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-05-21 15:47:31 --- ERROR: ReflectionException [ 0 ]: Method action_episode does not exist ~ SYSPATH/classes\kohana\request.php [ 882 ]
2010-05-21 15:47:45 --- ERROR: ReflectionException [ 0 ]: Method action_episode does not exist ~ SYSPATH/classes\kohana\request.php [ 882 ]
2010-05-21 15:48:37 --- ERROR: ReflectionException [ 0 ]: Method action_episode does not exist ~ SYSPATH/classes\kohana\request.php [ 882 ]
2010-05-21 16:11:38 --- ERROR: Database_Exception [ 1146 ]: Table 'autotvtosab.serjoinrep' doesn't exist [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            INNER JOIN episodes ep ON ep.id =
                (
                SELECT
                    id
                FROM
                    episodes
                WHERE
                    id IN (SELECT episode_id FROM serjoinrep WHERE series_id = s.id)
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
                15 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-21 16:13:15 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-21 16:13:22 --- ERROR: ReflectionException [ 0 ]: Method action_episode does not exist ~ SYSPATH/classes\kohana\request.php [ 882 ]
2010-05-21 16:14:17 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-21 16:14:30 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-21 16:35:49 --- ERROR: Database_Exception [ 1146 ]: Table 'autotvtosab.serjoinrep' doesn't exist [ SELECT
                s.*,
                MAX(e.first_aired) AS last_aired,
                ep.episode AS ep_num,
                ep.id AS ep_id,
                ep.season AS ep_sea,
                ep.first_aired AS ep_aired
            FROM
                series s
            INNER JOIN episodes ep ON ep.id =
                (
                SELECT
                    id
                FROM
                    episodes
                WHERE
                    id IN (SELECT episode_id FROM serjoinrep WHERE series_id = s.id)
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
2010-05-21 16:37:04 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-21 16:42:11 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'FROM
    series s
INNER JOIN episodes ep ON ep.id =
    (
    SELECT
        id
' at line 7 [ SELECT
    s.*,
    ep.first_aired AS last_aired,
    ep.episode AS ep_num,
    ep.id AS ep_id,
    ep.season AS ep_sea,
FROM
    series s
INNER JOIN episodes ep ON ep.id =
    (
    SELECT
        id
    FROM
        episodes
    WHERE
        id IN (SELECT episode_id FROM serjoinep WHERE series_id = s.id)
    ORDER BY
        first_aired DESC
    LIMIT 1
    )
ORDER BY
    last_aired DESC
            LIMIT
                15
            OFFSET
                0 ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-21 16:43:46 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-21 16:59:26 --- ERROR: ReflectionException [ 0 ]: Method action_episode does not exist ~ SYSPATH/classes\kohana\request.php [ 882 ]
2010-05-21 18:35:10 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-21 18:36:22 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-21 18:37:26 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ SYSPATH/classes\kohana\core.php [ 861 ]
2010-05-21 18:39:07 --- ERROR: Database_Exception [ 1053 ]: Server shutdown in progress [ SELECT COUNT(*) AS `records_found` FROM `episodes` JOIN `serjoinep` ON (`serjoinep`.`episode_id` = `episodes`.`id`) WHERE `serjoinep`.`series_id` = '27' ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 173 ]
2010-05-21 19:58:13 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-21 20:01:00 --- ERROR: ErrorException [ 1 ]: Maximum execution time of 60 seconds exceeded ~ APPPATH/classes\posters.php [ 80 ]
2010-05-21 20:01:59 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-21 20:02:33 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-21 20:03:05 --- ERROR: ReflectionException [ 0 ]: Method action_episode does not exist ~ SYSPATH/classes\kohana\request.php [ 882 ]
2010-05-21 20:03:14 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-21 20:03:20 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-21 20:03:29 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-21 20:03:38 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]
2010-05-21 20:03:43 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: episodes/index.php/http:/thetvdb.com/banners/124 ~ SYSPATH/classes\kohana\request.php [ 579 ]