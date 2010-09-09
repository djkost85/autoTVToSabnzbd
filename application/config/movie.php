<?php defined('SYSPATH') or die('No direct script access.');

$filename = 'application/config/movie.data';

return array_merge_recursive(array(
    'tmdb' => array(
        'apiKey' => 'a7777b7e2df94890ac33340df2c4e6e6',
    ),
    'rss' => array(
        'numberOfResults' => 10
    ),
    ),
    (is_readable($filename)) ? unserialize(file_get_contents($filename)) : array()
);


?>