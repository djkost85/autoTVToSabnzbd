<?php

class Helper_Path {

    public static function mkdir_recursive($path, $filemode = 0777) {
        $return = mkdir($path, $filemode, true);
        if (!$return) {
            throw new RuntimeException('Failed to create folders...');
        }
    }

    public static function chmod_recursive($path, $filemode = 0777) {
        if (!is_dir($path)) {
            return chmod($path, $filemode);
        }

        $dh = opendir($path);
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..') {
                $fullpath = $path . '/' . $file;
                if (is_link($fullpath)) {
                    return FALSE;
                } else if (!is_dir($fullpath) && !chmod($fullpath, $filemode)) {
                    return FALSE;
                } else if (!self::chmod_recursive($fullpath, $filemode)) {
                    return FALSE;
                }
            }
        }

        closedir($dh);

        if (chmod($path, $filemode)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>
