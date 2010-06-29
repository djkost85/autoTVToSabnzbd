<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'imdb' => false,
    'default' => array(
        'saveImagesAsNew' => false,
        'cacheTimeImages' => (3600 * 3),
        'TheTvDB_api_key' => '34FC8C53F6E85F7A',
        'NzbMatrix_api_key' => 'c9f6b98125730454b47fcc3b5385916e',
    ),

    'Sabnzbd' => array(
        'api_key' => '0c5f1052c84253a0e0deff090b73e691',
        'url' => 'http://localhost:8080',
    ),

    'rss' => array(
        'numberOfResults' => 5,
        'howOld' => '-1 days' //"-1 week" "-2 days" "-4 hours" "-2 seconds" uses strtotime()
    )
);

?>