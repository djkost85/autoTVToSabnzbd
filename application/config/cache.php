<?php defined('SYSPATH') or die('No direct script access.');
return array
(
    'default' => array
    (
        'driver'         => 'file',
        'cache_dir'      => APPPATH.'cache/default_cache',
        'default_expire' => 3600,
    ),

    'sabnzbd' => array
    (
        'driver'         => 'file',
        'cache_dir'      => APPPATH.'cache/sabnzbd_cache',
        'default_expire' => floor(604800*3)
    )
);
