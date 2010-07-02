<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rss
 *
 * @author morre95
 */
class Model_Rss extends ORM {
    //TRUNCATE TABLE rss

    public function truncate() {
        DB::query(Database::DELETE, 'TRUNCATE TABLE rsses')->execute($this->_db);
    }

    public function search($q) {
        $query = "SELECT * FROM rsses WHERE title LIKE :q";
        return DB::query(Database::SELECT, $query)
                ->param(':q', "%$q%")
                ->as_object()
                ->execute($this->_db);
    }

    public function inFeed($q) {
        $query = "SELECT COUNT(*) AS num FROM rsses WHERE title LIKE :q";
        return (DB::query(Database::SELECT, $query)
                ->param(':q', "%$q%")
                ->execute($this->_db)
                ->get('num') > 0);
    }

    public function alreadySaved($q) {
        return ($this->search($q)->count() > 0);
    }
}
?>
