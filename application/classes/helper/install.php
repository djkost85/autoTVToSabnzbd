<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Install {

    public static function checkEnv() {
        $error = array();
        if (!version_compare(PHP_VERSION, '5.2.3', '>=')) {
            $error[] = "AutoTvToSab requires PHP 5.2.3 or newer, this version is " . PHP_VERSION;
        }
        if (!extension_loaded('curl')) {
            $error[] = "AutoTvToSab requires <a href=\"http://php.net/curl\">cURL</a> for the Remote class.";
        }
        if (!function_exists('gd_info')) {
            $error[] = "AutoTvToSab requires <a href=\"http://php.net/gd\">GD</a> v2 for the Image class.";
        }
        if (!function_exists('spl_autoload_register')) {
            $error[] = "PHP <a href=\"http://www.php.net/spl\">SPL</a> is either not loaded or not compiled in.";
        }
        if (!class_exists('ReflectionClass')) {
            $error[] = "PHP <a href=\"http://www.php.net/reflection\">reflection</a> is either not loaded or not compiled in.";
        }
        if (!function_exists('filter_list')) {
            $error[] = "The <a href=\"http://www.php.net/filter\">filter</a> extension is either not loaded or not compiled in.";
        }
        if (!extension_loaded('iconv')) {
            $error[] = "The <a href=\"http://php.net/iconv\">iconv</a> extension is not loaded.";
        }
        if (!extension_loaded('mbstring') && !ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING) {
            $error[] = "The <a href=\"http://php.net/mbstring\">mbstring</a> extension is overloading PHP's native string functions.";
        }
        if (!is_dir(SYSPATH) AND is_file(SYSPATH . 'classes/kohana' . EXT)) {
            $error[] = "The configured <code>system</code> directory does not exist or does not contain required files.";
        }
        if (!is_file(APPPATH . 'bootstrap' . EXT)) {
            $error[] = "The configured <code>application</code> directory does not exist or does not contain required files.";
        }

        #Check if dir is writable
        if (is_dir(APPPATH . 'cache') && !is_writable(APPPATH . 'cache')) {
            chmod(APPPATH . 'cache', 0777);
        }

        if (!is_dir(APPPATH . 'cache') || !is_writable(APPPATH . 'cache')) {
            $error[] = "The <code>" . APPPATH . "cache/</code> directory is not writable.";
        }

        if (is_dir(APPPATH . 'logs') && !is_writable(APPPATH . 'logs')) {
            chmod(APPPATH . 'logs', 0777);
        }

        if (!is_dir(APPPATH . 'logs') || !is_writable(APPPATH . 'logs')) {
            $error[] = "The <code>" . APPPATH . "logs/</code> directory is not writable.";
        }

        if (is_dir(APPPATH . 'config') && !is_writable(APPPATH . 'config')) {
            chmod(APPPATH . 'config', 0777);
        }

        if (!is_dir(APPPATH . 'config') || !is_writable(APPPATH . 'config')) {
            $error[] = "The <code>" . APPPATH . "config/</code> directory is not writable.";
        }

        if (is_dir(realpath(APPPATH . '../images')) && !is_writable(realpath(APPPATH . '../images'))) {
            Helper_Path::chmod_recursive(realpath(APPPATH . '../images'), 0777);
        }

        if (!is_dir(realpath(APPPATH . '../images')) ||
                !is_writable(realpath(APPPATH . '../images')) ||
                !is_writable(realpath(APPPATH . '../images/__cache')) ||
                !is_writable(realpath(APPPATH . '../images/banner')) ||
                !is_writable(realpath(APPPATH . '../images/poster')) ||
                !is_writable(realpath(APPPATH . '../images/fanart'))) {
            $error[] = "The <code>" . APPPATH . "../images</code> directory or it´s subdirectories is not writable.";
        }


        if (!@preg_match('/^.$/u', 'ñ')) {
            $error[] = "<a href=\"http://php.net/pcre\">PCRE</a> has not been compiled with UTF-8 support.";
        }
        if (!@preg_match('/^\pL$/u', 'ñ')) {
            $error[] = "<a href=\"http://php.net/pcre\">PCRE</a> has not been compiled with Unicode property support.";
        }
        if (!(isset($_SERVER['REQUEST_URI']) OR !isset($_SERVER['PHP_SELF']) OR !isset($_SERVER['PATH_INFO']))) {
            $error[] = "Neither <code>\$_SERVER['REQUEST_URI']</code>, <code>\$_SERVER['PHP_SELF']</code>, or <code>\$_SERVER['PATH_INFO']</code> is available.";
        }

        return $error;
    }

    public static function getWarnings() {
        $error = array();
        $baseUrl = str_replace('//', '/', '/' . trim(str_replace('/index.php/' . Request::instance()->uri, '', $_SERVER['PHP_SELF']) . '/'));
        if ($baseUrl != Kohana::$base_url) {
            $error[] = "AutoTvToSab requires this line <br />
                        <code>'base_url' => \$baseUrl,</code><br />
                        in application/bootstrap.php to be set to:<br />
                        <code>'base_url' => '$baseUrl',</code>";
        }

        return $error;
    }

    public static function checkSabUrl($url) {
        try {
            return Remote::get($url, array(
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 6.1; nl; rv:1.9.2) Gecko/20100115 Firefox/3.6',
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 5,
            ));
        } catch (Exception $e) {
            return 404;
        }
    }

}

?>
