<?php defined('SYSPATH') or die('No direct script access.');

/**
CREATE TABLE `movies` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`score` FLOAT NOT NULL ,
`popularity` INT( 6 ) NOT NULL ,
`translated` BOOL NOT NULL ,
`adult` BOOL NOT NULL ,
`language` VARCHAR( 2 ) NOT NULL ,
`original_name` VARCHAR( 150 ) NOT NULL ,
`name` VARCHAR( 150 ) NULL ,
`alternative_name` VARCHAR( 150 ) NULL ,
`movie_type` VARCHAR( 10 ) NOT NULL ,
`tmdb_id` INT( 11 ) NOT NULL ,
`imdb_id` VARCHAR( 10 ) NOT NULL ,
`url` VARCHAR( 100 ) NOT NULL ,
`votes` INT( 11 ) NOT NULL ,
`rating` FLOAT( 2 ) NOT NULL ,
`certification` VARCHAR( 10 ) NOT NULL ,
`overview` TEXT NOT NULL ,
`released` DATE NOT NULL ,
`posters` TEXT NOT NULL ,
`backdrops` TEXT NOT NULL ,
`version` INT( 4 ) NOT NULL ,
`last_modified_at` DATETIME NOT NULL ,
`matrix_cat` VARCHAR( 10 ) NOT NULL
) ENGINE = MYISAM ;


ALTER TABLE `movies` ADD `trailer` VARCHAR( 150 ) NULL AFTER `url` ,
ADD `budget` INT( 11 ) NULL AFTER `trailer` ,
ADD `runtime` INT( 11 ) NULL AFTER `budget` ,
ADD `tagline` VARCHAR( 150 ) NULL AFTER `runtime`

 */

class Model_Movie extends ORM {

    public function search($search) {
        $query = "SELECT * FROM movies WHERE name LIKE :q";
        return DB::query(Database::SELECT, $query)
                ->param(':q', "%$q%")
                ->as_object()
                ->execute($this->_db);
    }

    public function isIdAdded($id) {
        $query = $this->where('tmdb_id', '=', $id);

        if ($query->count_all() > 0) {
            $result = $query->find();
            return $result->name;
        }

        return false;
    }

    public function isAdded($name) {
        $count = $this->where('name', '=', $name)->count_all();
        if($count > 0) {
            return true;
        }

        $count = $this->where('original_name', '=', $name)->count_all();
        if($count > 0) {
            return true;
        }

        $count = $this->where('alternative_name', '=', $name)->count_all();
        if($count > 0) {
            return true;
        }

        return false;
    }

    public function isImdbAdded($imdb) {
        return ($this->where('imdb_id', '=', $imdb)->count_all() > 0);
    }

    public static function alterTable() {
        $sql = "SHOW FULL COLUMNS FROM `movies`";
        $results = DB::query(Database::SELECT, $sql)->execute(Database::instance());

        $alter = true;
        foreach ($results as $result) {
            if ($result['Field'] == 'trailer') {
                $alter = false;
            }
        }

        if ($alter) {
            $sql = "ALTER TABLE `movies` ADD `trailer` VARCHAR( 150 ) NULL AFTER `url` ,
ADD `budget` INT( 11 ) NULL AFTER `trailer` ,
ADD `runtime` INT( 11 ) NULL AFTER `budget` ,
ADD `tagline` VARCHAR( 150 ) NULL AFTER `runtime`";
            DB::query(Database::INSERT, $sql)->execute(Database::instance());
        }
    }

    public static function installTable() {
        $sql = "CREATE TABLE `movies` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`popularity` INT( 6 ) NOT NULL ,
`translated` BOOL NOT NULL ,
`adult` BOOL NOT NULL ,
`language` VARCHAR( 2 ) NOT NULL ,
`original_name` VARCHAR( 150 ) NOT NULL ,
`name` VARCHAR( 150 ) NULL ,
`alternative_name` VARCHAR( 150 ) NULL ,
`movie_type` VARCHAR( 10 ) NOT NULL ,
`tmdb_id` INT( 11 ) NOT NULL ,
`imdb_id` VARCHAR( 10 ) NOT NULL ,
`url` VARCHAR( 100 ) NOT NULL ,
`trailer` VARCHAR( 150 ) NULL ,
`budget` INT( 11 ) NULL ,
`runtime` INT( 11 ) NULL ,
`tagline` VARCHAR( 150 ) NULL ,
`votes` INT( 11 ) NOT NULL ,
`rating` FLOAT( 2 ) NOT NULL ,
`certification` VARCHAR( 10 ) NOT ,
`overview` TEXT NOT NULL ,
`released` DATE NOT NULL ,
`posters` TEXT NOT NULL ,
`backdrops` TEXT NOT NULL ,
`version` INT( 4 ) NOT NULL ,
`last_modified_at` DATETIME NOT NULL ,
`matrix_cat` VARCHAR( 10 ) NOT NULL
) ENGINE = MYISAM ;";
        DB::query(Database::INSERT, $sql)->execute(Database::instance());
    }
}

?>
