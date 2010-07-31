<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class Model_Series extends ORM {
    protected $_has_many = array('episodes' => array('through' => 'serjoinep'));
}

class Model_Episode extends ORM {
    protected $_has_many = array('series' => array('through' => 'serjoinep'));
}

class Model_Serjoinep extends ORM {
    protected $_belongs_to = array('serie' => array(), 'episode' => array());
}


$series = ORM::factory('series', $id);
$series->remove('episodes', ORM::factory('episode'));
$series->delete();

$query = "SELECT `series`.*
          FROM `series`
          JOIN `serjoinep` ON (`serjoinep`.`episode_id` = `series`.`id`)
          JOIN `episodes` ON (`episodes`.`id` = `serjoinep`.`episode_id`)
          GROUP BY `episodes`.`id`
          ORDER BY `episodes`.`first_aired` DESC
          LIMIT $limit OFFSET $offset";

"SELECT
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
GROUP BY
    s.id
ORDER BY
    last_aired DESC
LIMIT
    $limit
OFFSET
    $offset";

"SELECT
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
    $limit
OFFSET
    $offset";
/*
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
}
 */

?>
