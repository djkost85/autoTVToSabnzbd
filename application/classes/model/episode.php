<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of episodes
 *
 * @author Morre95
 */
class Model_Episode extends ORM {

    protected $_belongs_to = array('series' => array());

    protected $_has_many = array('downloads' => array());

    protected $_filters = array(
        true => array('trim' => array()),
        'guest_stars' => array('trim' => array('|')),
        'writer' => array('trim' => array('|')),
        );

    public function getSeriesInfo($id = null) {
        if (is_null($id)) $id = $this->id;
        $query = "
            SELECT
                s.*
            FROM
                series s, episodes e
            WHERE
                e.id = :id AND e.series_id = s.id
            ORDER BY
                s.id";

        $result = DB::query(Database::SELECT, $query)
                ->bind(':id', $id)
                ->as_object()
                ->execute($this->_db)
                ->as_array();

        return $result[0];
    }

    public function isDownloaded($id = null) {
        if (is_null($id)) $id = $this->id;
        $query = "SELECT
                    COUNT(*) AS num
                FROM
                    downloads
                WHERE
                    episode_id = :id";

        return (DB::query(Database::SELECT, $query)
                ->bind(':id', $id)
                ->execute($this->_db)
                ->get('num') > 0);
    }

    public function getAllDownloads() {
        $query = "SELECT
                    d.*
                FROM
                    downloads d
                JOIN
                    episodes e
                ON
                    e.id = d.episode_id
                GROUP BY
                    d.id
                ORDER BY
                    d.modified DESC
                    ";

        return DB::query(Database::SELECT, $query)
                ->bind(':id', $id)
                ->as_object()
                ->execute($this->_db)
                ->as_array();
    }

    public function getNext($id) {
        $query = "SELECT
                    first_aired
                FROM
                    episodes
                WHERE
                    first_aired > CURDATE()
                AND
                    series_id IN (SELECT series_id FROM episodes WHERE id = :id)
                ORDER BY
                    first_aired ASC
                LIMIT 1";
       
        return DB::query(Database::SELECT, $query)
                ->bind(':id', $id)
                ->as_object()
                ->execute($this->_db)
                ->get('first_aired');
    }

}
?>
