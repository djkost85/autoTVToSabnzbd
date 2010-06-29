<?php defined('SYSPATH') or die('No direct script access.');

class Helper {
    /**
    * Returns TRUE if the $filename is readable, or FALSE otherwise.
    * This function uses the PHP include_path, where PHP's is_readable()
    * does not.
    *
    * @param string   $filename
    * @return boolean
    */
    public static function isReadable($filename) {
        if (!$fh = @fopen($filename, 'r', true)) {
            return false;
        }

        return true;
    }

    function gerParams($url) {
        $query = parse_url($url, PHP_URL_QUERY);
        if ($query === null) {
            return array();
        }
        $return = array();
        foreach (explode('&', $query) as $item) {
            list($key, $value) = explode('=', $item);
            $return[$key] = $value;
        }
        return $return;
    }
}

?>
