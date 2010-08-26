<?php defined('SYSPATH') or die('No direct script access.');

class MsgFlash {
    
    protected static $_name = 'msgFlash';

    public static function set($value, $error = false) {
        $session = Session::instance();
        $name = self::$_name;

        if ($error) {
            $name = $name . '_error';
        }

        $get = $session->get($name, null);
        if (!is_null($get)) {
            $value = $get . ', ' . $value;
        }

        $session->set($name, $value);
    }

    public static function has($error = false) {
        $name = self::$_name;
        if ($error) {
            $name = $name . '_error';
        }
        return !is_null(Session::instance()->get($name, null));
    }

    public static function hasError() {
        $name = self::$_name . '_error';
        return !is_null(Session::instance()->get($name, null));
    }

    public static function get($error = false) {
        $sess = Session::instance();
        $name = self::$_name;
        if ($error) {
            $name = $name . '_error';
        }

        $falsh =  $sess->get($name);
        $sess->delete($name);
        return $falsh;
    }
}

?>
