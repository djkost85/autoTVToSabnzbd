<?php defined('SYSPATH') or die('No direct script access.');

$filename = 'application/config/default.data';

return array_merge_recursive(array(
    'imdb' => false,
    'default' => array(
        'saveImagesAsNew' => false,
        'cacheTimeImages' => 7776000, //90 days
    )
    ),
    (is_readable($filename)) ? unserialize(file_get_contents($filename)) : array()
);



?>