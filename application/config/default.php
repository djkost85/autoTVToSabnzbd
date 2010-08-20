<?php defined('SYSPATH') or die('No direct script access.');


return unserialize(file_get_contents(realpath('application/config/default.data')));

?>