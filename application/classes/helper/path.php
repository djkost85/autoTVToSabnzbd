<?php

class Helper_Path {

    public static function mkdir_recursive($path, $filemode = 0777) {
        if (is_dir($path)) {
            return;
        }
        
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

    public static function delete_dir_recursive($directory, $empty = false) {
        if (substr($directory, -1) == "/") {
            $directory = substr($directory, 0, -1);
        }

        if (!file_exists($directory) || !is_dir($directory)) {
            return false;
        } elseif (!is_readable($directory)) {
            return false;
        } else {
            $directoryHandle = opendir($directory);

            while ($contents = readdir($directoryHandle)) {
                if ($contents != '.' && $contents != '..') {
                    $path = $directory . "/" . $contents;

                    if (is_dir($path)) {
                        self::delete_dir_recursive($path);
                    } else {
                        unlink($path);
                    }
                }
            }

            closedir($directoryHandle);

            if ($empty == false) {
                if (!rmdir($directory)) {
                    return false;
                }
            }

            return true;
        }
    }

}

?>
