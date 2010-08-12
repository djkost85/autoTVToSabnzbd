<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of series
 *
 * @author Morre95
 */
class Model_Series extends ORM {
//    protected $_has_many = array('episodes' => array('through' => 'serjoinep'));
    protected $_has_many = array('episodes' => array());

    protected $_filters = array( 
        true => array('trim' => array()),
        'actors' => array('trim' => array('|')),
        'genre' => array('trim' => array('|'))
        );

    public function isAdded($name) {
        $count = $this->where('series_name', '=', $name)->count_all();
        return ($count > 0) ? true : false;
    }

    public function removeAllRelationships() {
        $alias = key($this->_has_many);
        foreach ($this->$alias->find_all() as $model) {
            $farId = $model->pk();
            DB::delete($this->_has_many[$alias]['through'])
                    ->where($this->_has_many[$alias]['foreign_key'], '=', $this->pk())
                    ->where($this->_has_many[$alias]['far_key'], '=', $farId)
                    ->execute($this->_db);

            DB::delete($alias)
                    ->where('id', '=', $farId)
                    ->execute($this->_db);
        }
// Do you mean I should add a new field (series_id) in the episodes table or what?
    }

    public function getByFirtAired($limit, $offset) {
//    public function getByFirtAired() {
//        $query = "SELECT
//                s.*,
//                MAX(e.first_aired) AS last_aired
//            FROM
//                series s
//            LEFT JOIN
//                episodes e ON e.series_id = s.id
//            GROUP BY
//                s.id
//            ORDER BY
//                last_aired DESC";


        $query = "SELECT
                s.*,
                MAX(e.first_aired) AS last_aired
            FROM
                series s
            LEFT JOIN
                episodes e ON e.series_id = s.id
            WHERE
                e.first_aired < CURDATE()
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                :limit
            OFFSET
                :offset";
        return DB::query(Database::SELECT, $query)
                ->bind(':limit', $limit)
                ->bind(':offset', $offset)
                ->as_object()
                ->execute($this->_db);
        
    }

    /**
     *
     * $query = "SELECT
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
                    id = e.id
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
                :limit
            OFFSET
                :offset";
     *
     * 
               INNER JOIN episodes ep ON ep.id =
                (
                SELECT
                    id
                FROM
                    episodes
                WHERE
                    id = e.id
                ORDER BY
                    first_aired DESC
                LIMIT 1
                )
     */

    public function getPreviousAired($id) {
        /*return DB::query(Database::SELECT,
            "SELECT `series`.*, MAX(`episodes`.`first_aired`)
            FROM `series`
            JOIN `serjoinep` ON (`serjoinep`.`episode_id` = `series`.`id`)
            JOIN `episodes` ON (`episodes`.`id` = `serjoinep`.`episode_id`)
            GROUP BY `episodes`.`id`
            ORDER BY `episodes`.`id` DESC
            LIMIT 1")->as_object()->execute($this->_db);*/
        return DB::query(Database::SELECT,
            "SELECT
                e.*,
                MAX(e.first_aired) AS last_aired
            FROM
                episodes e
            LEFT JOIN
                serjoinep se ON se.series_id = $id AND se.episode_id = e.id
            WHERE
                e.first_aired < CURDATE()
            GROUP BY
                s.id
            ORDER BY
                last_aired DESC
            LIMIT
                1")->as_object()->execute($this->_db);
    }

    protected function _getRandBanner() {
        $query = "SELECT
                    banner
                FROM
                    series
                ORDER BY rand()
                LIMIT 1";
        return DB::query(Database::SELECT, $query)
                ->execute($this->_db)
                ->get('banner');
    }

    public static function getRandBanner() {
        $series = new Model_Series;
        return $series->_getRandBanner();
    }

    public function search($q) {
        $query = "SELECT * FROM series WHERE series_name LIKE :q";
        return DB::query(Database::SELECT, $query)
                ->param(':q', "%$q%")
                ->as_object()
                ->execute($this->_db);
    }
    
    public function searchEnded($limit) {
        $query = "SELECT * FROM series WHERE status LIKE '%Ended%' LIMIT :limit";
        return DB::query(Database::SELECT, $query)
                ->param(':limit', $limit)
                ->as_object()
                ->execute($this->_db);
    }
}

?>
