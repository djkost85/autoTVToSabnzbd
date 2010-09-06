<?php defined('SYSPATH') or die('No direct script access.');

$filename = 'application/config/default.data';

return array_merge_recursive(array(
    'imdb' => false,
    'default' => array(
        'saveImagesAsNew' => false,
        'cacheTimeImages' => 7776000, //90 days
    ),
    'tmdb' => array(
        'apiKey' => 'a7777b7e2df94890ac33340df2c4e6e6',
    ),
    ),
    (is_readable($filename)) ? unserialize(file_get_contents($filename)) : array()
);


?>