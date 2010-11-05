<?php defined('SYSPATH') or die('No direct script access.');

$filename = 'application/config/subtitles.data';

return (is_readable($filename)) ? unserialize(file_get_contents($filename)) : array();

?>
